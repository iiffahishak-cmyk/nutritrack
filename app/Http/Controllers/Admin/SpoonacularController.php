<?php

// ============================================================
//  app/Http/Controllers/Admin/SpoonacularController.php
// ============================================================

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodItem;
use App\Models\Meal;
use App\Services\SpoonacularService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SpoonacularController extends Controller
{
    /**
     * Official NutriTrack cuisine list.
     * Do not include International because it is not one of your final project cuisines.
     */
    private array $cuisineOptions = [
        'Malay',
        'Chinese',
        'Indian',
        'Western',
        'Middle Eastern',
    ];

    public function __construct(
        private readonly SpoonacularService $spoonacular
    ) {}

    // ──────────────────────────────────────────────────────────────────────
    //  GET /admin/spoonacular
    //  Admin import dashboard — shows stats and the import form
    // ──────────────────────────────────────────────────────────────────────

    public function index()
    {
        $stats = [
            'total'    => FoodItem::count(),
            'verified' => FoodItem::where('is_verified', true)->count(),
            'pending'  => FoodItem::where('is_verified', false)->count(),
            'by_slot'  => FoodItem::selectRaw('meal_time, COUNT(*) as count')
                ->groupBy('meal_time')
                ->pluck('count', 'meal_time'),
        ];

        $pendingItems = FoodItem::pendingVerification()
            ->latest()
            ->take(10)
            ->get();

        $cuisineOptions = $this->cuisineOptions;

        return view('admin.spoonacular.index', compact(
            'stats',
            'pendingItems',
            'cuisineOptions'
        ));
    }

    // ──────────────────────────────────────────────────────────────────────
    //  POST /admin/spoonacular/import
    //  Trigger an API import for a given DCR and meal slot
    // ──────────────────────────────────────────────────────────────────────

    public function import(Request $request)
    {
        $validated = $request->validate([
            'dcr'       => ['required', 'numeric', 'min:800', 'max:5000'],
            'meal_time' => ['required', Rule::in(['Breakfast', 'Lunch', 'Dinner', 'Snack', 'Any'])],
            'cuisine'   => ['nullable', 'string', Rule::in(array_merge($this->cuisineOptions, ['']))],
            'limit'     => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $result = $this->spoonacular->fetchAndStore(
            dcr:      (float) $validated['dcr'],
            mealTime: $validated['meal_time'],
            cuisine:  $validated['cuisine'] ?? '',
            limit:    (int) ($validated['limit'] ?? 20),
        );

        $message = "Import complete: {$result['saved']} new, {$result['updated']} updated, "
            . "{$result['skipped']} skipped. "
            . "Calorie window: {$result['calorie_min']}–{$result['calorie_max']} kcal.";

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'result'  => $result,
            ]);
        }

        return redirect()->route('admin.spoonacular.index')
            ->with('success', $message);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  POST /admin/spoonacular/import-profile
    //  Bulk import for all 4 slots at once based on a DCR
    // ──────────────────────────────────────────────────────────────────────

    public function importProfile(Request $request)
    {
        $validated = $request->validate([
            'dcr'     => ['required', 'numeric', 'min:800', 'max:5000'],
            'cuisine' => ['nullable', 'string', Rule::in(array_merge($this->cuisineOptions, ['']))],
        ]);

        $summary = $this->spoonacular->fetchForProfile(
            dcr:     (float) $validated['dcr'],
            cuisine: $validated['cuisine'] ?? '',
        );

        return redirect()->route('admin.spoonacular.index')
            ->with(
                'success',
                "Bulk import done: {$summary['total_saved']} new items, "
                . "{$summary['total_updated']} updated across all 4 meal slots."
            );
    }

    // ──────────────────────────────────────────────────────────────────────
    //  GET /admin/food-items
    //  Browse all imported food items with search, filter, and pagination
    // ──────────────────────────────────────────────────────────────────────

    public function listItems(Request $request)
    {
        $query = FoodItem::query();

        if ($request->filled('search')) {
            $query->where('meal_name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('meal_time')) {
            $query->where('meal_time', $request->meal_time);
        }

        if ($request->filled('cuisine')) {
            $query->where('cuisine_type', $request->cuisine);
        }

        if ($request->filled('status')) {
            match ($request->status) {
                'verified' => $query->where('is_verified', true),
                'pending'  => $query->where('is_verified', false),
                'inactive' => $query->where('is_active', false),
                default    => null,
            };
        }

        if ($request->filled('min_cal')) {
            $query->where('calories', '>=', (int) $request->min_cal);
        }

        if ($request->filled('max_cal')) {
            $query->where('calories', '<=', (int) $request->max_cal);
        }

        $items = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $filterCounts = [
            'total'    => FoodItem::count(),
            'verified' => FoodItem::where('is_verified', true)->count(),
            'pending'  => FoodItem::where('is_verified', false)->count(),
        ];

        return view('admin.spoonacular.food-items', compact(
            'items',
            'filterCounts'
        ));
    }

    // ──────────────────────────────────────────────────────────────────────
    //  PATCH /admin/food-items/{id}/verify
    //  Admin approves one item and adds it to main meals table
    // ──────────────────────────────────────────────────────────────────────

    public function verify(int $id)
    {
        $item = FoodItem::findOrFail($id);

        $item->update([
            'is_verified' => true,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        $this->promoteFoodItemToMeal($item);

        return back()->with('success', "\"{$item->meal_name}\" has been verified and added to the main meal database.");
    }

    // ──────────────────────────────────────────────────────────────────────
    //  PATCH /admin/food-items/{id}/toggle-active
    //  Toggle the is_active flag without deleting
    // ──────────────────────────────────────────────────────────────────────

    public function toggleActive(int $id)
    {
        $item = FoodItem::findOrFail($id);

        $newState = ! $item->is_active;

        $item->update([
            'is_active' => $newState,
        ]);

        $label = $newState ? 'activated' : 'deactivated';

        return back()->with('success', "\"{$item->meal_name}\" has been {$label}.");
    }

    // ──────────────────────────────────────────────────────────────────────
    //  PATCH /admin/food-items/verify-all-pending
    //  Bulk verify all pending items and add them to main meals table
    // ──────────────────────────────────────────────────────────────────────

    public function verifyAll()
    {
        $items = FoodItem::where('is_verified', false)
            ->where('is_active', true)
            ->get();

        foreach ($items as $item) {
            $item->update([
                'is_verified' => true,
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);

            $this->promoteFoodItemToMeal($item);
        }

        return back()->with('success', "{$items->count()} items verified and added to the main meal database.");
    }

    // ──────────────────────────────────────────────────────────────────────
    //  DELETE /admin/food-items/{id}
    //  Hard delete a food item
    // ──────────────────────────────────────────────────────────────────────

    public function destroy(int $id)
    {
        $item = FoodItem::findOrFail($id);

        $name = $item->meal_name;

        $item->delete();

        return back()->with('success', "\"{$name}\" has been deleted.");
    }

    // ──────────────────────────────────────────────────────────────────────
    //  POST /admin/spoonacular/import-single
    //  Import one recipe by Spoonacular ID
    // ──────────────────────────────────────────────────────────────────────

    public function importSingle(Request $request)
    {
        $validated = $request->validate([
            'spoonacular_id' => ['required', 'integer', 'min:1'],
            'meal_time'      => ['required', Rule::in(['Breakfast', 'Lunch', 'Dinner', 'Snack', 'Any'])],
        ]);

        $raw = $this->spoonacular->fetchById((int) $validated['spoonacular_id']);

        if (! $raw) {
            return back()->withErrors([
                'spoonacular_id' => 'Recipe not found on Spoonacular.',
            ]);
        }

        $parsed = $this->spoonacular->parseNutrition($raw);

        FoodItem::updateOrCreate(
            [
                'spoonacular_id' => $parsed['spoonacular_id'],
            ],
            array_merge($parsed, [
                'meal_time'        => $validated['meal_time'],
                'source'           => 'spoonacular',
                'is_verified'      => false,
                'is_active'        => true,
                'last_synced_at'   => now(),
            ])
        );

        return back()->with('success', "Imported \"{$parsed['meal_name']}\" — pending verification.");
    }

    private function promoteFoodItemToMeal(FoodItem $item): void
    {
        if (! $item->is_active) {
            return;
        }

        $mealTime = $item->meal_time === 'Any'
            ? $this->guessMealTime($item)
            : $item->meal_time;

        Meal::updateOrCreate(
            [
                'spoonacular_id' => $item->spoonacular_id,
            ],
            [
                'meal_name'    => $item->meal_name,
                'description'  => $item->description,
                'calories'     => $item->calories,
                'protein'      => $item->protein_g,
                'carbs'        => $item->carbs_g,
                'fat'          => $item->fat_g,
                'meal_time'    => $mealTime,
                'cuisine_type' => $item->cuisine_type,
                'ingredients'  => $item->ingredients,
                'image_url'    => $item->image_url,
                'source'       => 'spoonacular',
            ]
        );
    }

    private function guessMealTime(FoodItem $item): string
    {
        $name = strtolower($item->meal_name . ' ' . $item->dish_types);

        if (
            str_contains($name, 'breakfast') ||
            str_contains($name, 'oat') ||
            str_contains($name, 'pancake')
        ) {
            return 'Breakfast';
        }

        if (
            str_contains($name, 'snack') ||
            str_contains($name, 'smoothie') ||
            str_contains($name, 'bar')
        ) {
            return 'Snack';
        }

        if (($item->calories ?? 0) <= 250) {
            return 'Snack';
        }

        return 'Lunch';
    }
}