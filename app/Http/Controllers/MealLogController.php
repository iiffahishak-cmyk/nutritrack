<?php
// ============================================================
//  app/Http/Controllers/MealLogController.php
// ============================================================
namespace App\Http\Controllers;

use App\Models\Meal;
use App\Services\MealImageService;
use App\Models\MealLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MealLogController extends Controller
{
    /**
     * POST /meals/save
     * Called via AJAX from the hybrid-recommend "Save Meal" button.
     * Saves a meal snapshot to meal_logs.
     */
    public function save(Request $request)
    {
        $v = $request->validate([
            'meal_id'   => ['required', 'integer'],
            'meal_time' => ['required', Rule::in(['Breakfast','Lunch','Dinner','Snack'])],
        ]);

        // Load the meal for a nutrition snapshot
        $meal = Meal::where('meal_id', $v['meal_id'])->first();
        if (! $meal) {
            return response()->json(['success' => false, 'message' => 'Meal not found.'], 404);
        }

        // Prevent saving the same meal twice on the same day for the same slot
        $exists = MealLog::where('user_id',   Auth::id())
                         ->where('meal_id',   $meal->meal_id)
                         ->where('meal_time', $v['meal_time'])
                         ->whereDate('date',  today())
                         ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => "{$meal->meal_name} is already saved for {$v['meal_time']} today.",
            ]);
        }

        MealLog::create([
            'user_id'   => Auth::id(),
            'meal_id'   => $meal->meal_id,
            'meal_time' => $v['meal_time'],
            'date'      => today(),
            'meal_name' => $meal->meal_name,
            'calories'  => $meal->calories     ?? 0,
            'protein_g' => $meal->protein       ?? 0,
            'carbs_g'   => $meal->carbs         ?? 0,
            'fat_g'     => $meal->fat           ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => "✓ {$meal->meal_name} saved to your meal plan!",
        ]);
    }
    
    public function saveMany(Request $request)
{
    $validated = $request->validate([
        'meals' => ['required', 'array', 'min:1'],
        'meals.*.meal_id' => ['required', 'integer', 'exists:meals,meal_id'],
        'meals.*.meal_time' => ['required', 'string', 'in:Breakfast,Lunch,Dinner,Snack'],
    ]);

    $savedCount = 0;

    foreach ($validated['meals'] as $item) {
        $meal = Meal::where('meal_id', $item['meal_id'])->first();

        if (! $meal) {
            continue;
        }

        $payload = [
            'meal_time' => $item['meal_time'],
            'date' => now()->toDateString(),
            'meal_name' => $meal->meal_name,
            'calories' => $meal->calories,
            'protein_g' => $meal->protein ?? 0,
            'carbs_g' => $meal->carbs ?? 0,
            'fat_g' => $meal->fat ?? 0,
        ];

        if (Schema::hasColumn('meal_logs', 'source')) {
            $payload['source'] = 'daily_plan';
        }

        MealLog::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'meal_id' => $meal->meal_id,
                'date' => now()->toDateString(),
                'meal_time' => $item['meal_time'],
            ],
            array_merge($payload, [
                'user_id' => auth()->id(),
                'meal_id' => $meal->meal_id,
            ])
        );

        $savedCount++;
    }

    return response()->json([
        'success' => true,
        'message' => "{$savedCount} meals saved to your diary.",
    ]);
}

    /**
     * DELETE /meals/log/{id}
     * Remove a saved meal from history.
     */
    public function destroy(int $id)
    {
        $log = MealLog::where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();
        $log->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Meal removed from history.');
    }
}