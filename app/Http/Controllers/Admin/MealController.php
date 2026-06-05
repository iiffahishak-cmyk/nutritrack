<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Services\MealImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MealController extends Controller
{
    /**
     * Standard cuisine values used in NutriTrack.
     */
    private array $cuisineOptions = [
        'Malay',
        'Chinese',
        'Indian',
        'Western',
        'Middle Eastern',
    ];

    /**
     * Convert old/inconsistent cuisine values into the current standard values.
     */
    private function normalizeCuisine(?string $cuisine): ?string
    {
        if ($cuisine === null) {
            return null;
        }

        $cuisine = trim($cuisine);

        if ($cuisine === '') {
            return null;
        }

        return match ($cuisine) {
            'International' => 'Middle Eastern',
            default => $cuisine,
        };
    }

    public function index(Request $request)
    {
        $query = Meal::query();

        if ($request->filled('search')) {
            $query->where('meal_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('meal_time')) {
            $query->where('meal_time', $request->meal_time);
        }

        if ($request->filled('cuisine_type')) {
            $selectedCuisine = $this->normalizeCuisine($request->cuisine_type);

            /*
             * This keeps the filter working even before old database records
             * are cleaned from International to Middle Eastern.
             */
            if ($selectedCuisine === 'Middle Eastern') {
                $query->whereIn('cuisine_type', ['Middle Eastern', 'International']);
            } else {
                $query->where('cuisine_type', $selectedCuisine);
            }
        }

        $meals = $query->latest()->paginate(10);

        /*
         * Do not generate this from the database.
         * If generated from database, old values such as International
         * will appear in the admin dropdown again.
         */
        $cuisines = $this->cuisineOptions;

        $totalMeals = Meal::count();

        $countByTime = Meal::selectRaw('meal_time, count(*) as total')
            ->groupBy('meal_time')
            ->pluck('total', 'meal_time')
            ->toArray();

        return view('admin.meals.index', compact(
            'meals',
            'cuisines',
            'totalMeals',
            'countByTime'
        ));
    }

    public function create()
    {
        $cuisines = $this->cuisineOptions;

        return view('admin.meals.create', compact('cuisines'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'meal_name'    => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'calories'     => ['required', 'numeric', 'min:0'],
            'protein'      => ['required', 'numeric', 'min:0'],
            'carbs'        => ['required', 'numeric', 'min:0'],
            'fat'          => ['required', 'numeric', 'min:0'],
            'meal_time'    => ['required', 'in:Breakfast,Lunch,Dinner,Snack'],
            'cuisine_type' => ['required', 'in:Malay,Chinese,Indian,Western,Middle Eastern,International'],
            'ingredients'  => ['nullable', 'string'],
        ]);

        $validated['cuisine_type'] = $this->normalizeCuisine($validated['cuisine_type']);

        Meal::create($validated);

        return redirect()->route('admin.meals.index')
            ->with('success', 'Meal added successfully!');
    }

    public function fetchImage(Meal $meal, MealImageService $imageService)
    {
        $imageUrl = $imageService->fetchImageUrl($meal->meal_name);

        if (! $imageUrl) {
            return back()->withErrors([
                'image' => 'Could not fetch an image for this meal. Please try another meal name.',
            ]);
        }

        $meal->update([
            'image_url' => $imageUrl,
        ]);

        return back()->with('success', 'Meal image updated successfully.');
    }

    public function edit($id)
    {
        $meal = Meal::findOrFail($id);
        $cuisines = $this->cuisineOptions;

        return view('admin.meals.edit', compact('meal', 'cuisines'));
    }

   public function update(Request $request, $id)
{
    $validated = $request->validate([
        'meal_name'    => ['required', 'string', 'max:255'],
        'description'  => ['nullable', 'string'],
        'calories'     => ['required', 'numeric', 'min:0'],
        'protein'      => ['required', 'numeric', 'min:0'],
        'carbs'        => ['required', 'numeric', 'min:0'],
        'fat'          => ['required', 'numeric', 'min:0'],
        'meal_time'    => ['required', 'in:Breakfast,Lunch,Dinner,Snack'],
        'cuisine_type' => ['required', 'in:Malay,Chinese,Indian,Western,Middle Eastern'],
        'ingredients'  => ['nullable', 'string'],
        'image_url'    => ['nullable', 'url'],
        'image_file'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
    ]);

    $meal = Meal::findOrFail($id);

    $updateData = [
        'meal_name'    => $validated['meal_name'],
        'description'  => $validated['description'] ?? null,
        'calories'     => $validated['calories'],
        'protein'      => $validated['protein'],
        'carbs'        => $validated['carbs'],
        'fat'          => $validated['fat'],
        'meal_time'    => $validated['meal_time'],
        'cuisine_type' => $validated['cuisine_type'],
        'ingredients'  => $validated['ingredients'] ?? null,
    ];

    if ($request->hasFile('image_file')) {
        $path = $request->file('image_file')->store('meal-images', 'public');
        $updateData['image_url'] = Storage::url($path);
    } elseif ($request->filled('image_url')) {
        $updateData['image_url'] = $validated['image_url'];
    }

    $meal->update($updateData);

    return redirect()->route('admin.meals.edit', $meal->meal_id)
        ->with('success', 'Meal updated successfully.');
}

public function destroy($id)
{
    $meal = Meal::findOrFail($id);
    $mealName = $meal->meal_name;

    $meal->delete();

    return redirect()->route('admin.meals.index')
        ->with('success', "\"{$mealName}\" deleted successfully.");
}
}
