<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfile;
use App\Models\Meal;
use App\Models\DailyRecommendation;
use App\Models\RecommendationItem;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function show()
    {
        $profile = UserProfile::where('user_id', Auth::id())->first();
        return view('profile.index', compact('profile'));
    }

    /**
     * Update only the weight and recalculate targets.
     * Use this for quick progress tracking.
     */
    public function updateWeight(Request $request)
    {
        $request->validate([
            'weight_kg' => 'required|numeric|min:1|max:300',
        ]);

        $profile = UserProfile::where('user_id', Auth::id())->firstOrFail();

        // 1. Activity Factors (Must match calculateAndSaveProfile for consistency)
        $activityFactors = [
            'sedentary'          => 1.2,
            'lightly_active'     => 1.375,
            'moderately_active'  => 1.55,
            'very_active'        => 1.725,
            'extra_active'       => 1.9,
        ];

        $newWeight = $request->weight_kg;
        $factor = $activityFactors[$profile->activity_level];

        // 2. Recalculate BMR
        if ($profile->gender === 'male') {
            $bmr = (10 * $newWeight) + (6.25 * $profile->height_cm) - (5 * $profile->age) + 5;
        } else {
            $bmr = (10 * $newWeight) + (6.25 * $profile->height_cm) - (5 * $profile->age) - 161;
        }

        // 3. Recalculate TDEE and DCR
        $tdee = $bmr * $factor;
        
        if ($profile->goal === 'lose_weight') {
            $dcr = $tdee - 500;
        } elseif ($profile->goal === 'gain_weight') {
            $dcr = $tdee + 500;
        } else {
            $dcr = $tdee;
        }

        // 4. Update Database
        $profile->update([
            'weight_kg'  => $newWeight,
            'bmr'        => round($bmr, 2),
            'tdee_value' => round($tdee, 2),
            'dcr_value'  => round($dcr, 2),
        ]);

        return redirect()->route('profile.index')
                         ->with('success', 'Weight updated! Your daily calorie targets have been recalculated.');
    }

    public function calculateAndSaveProfile(Request $request)
    {
        // ... (Keep your existing code here)
        $validatedData = $request->validate([
            'age'              => 'required|integer|min:1|max:120',
            'gender'           => 'required|in:male,female',
            'weight_kg'        => 'required|numeric|min:1',
            'height_cm'        => 'required|numeric|min:1',
            'activity_level'   => 'required|in:sedentary,lightly_active,moderately_active,very_active,extra_active',
            'goal'             => 'required|in:lose_weight,maintain,gain_weight',
            'allergies'        => 'nullable|string',
            'preferred_cuisine'=> 'nullable|string',
        ]);

        // ... (Keep the rest of your original calculateAndSaveProfile logic)
        $weight    = $validatedData['weight_kg'];
        $height    = $validatedData['height_cm'];
        $age       = $validatedData['age'];
        $gender    = $validatedData['gender'];
        $goal      = $validatedData['goal'];

        $activityFactors = [
            'sedentary'          => 1.2,
            'lightly_active'     => 1.375,
            'moderately_active'  => 1.55,
            'very_active'        => 1.725,
            'extra_active'       => 1.9,
        ];
        $activityFactor = $activityFactors[$validatedData['activity_level']];

        if ($gender === 'male') {
            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) + 5;
        } else {
            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;
        }

        $tdee = $bmr * $activityFactor;

        if ($goal === 'lose_weight') {
            $dcr = $tdee - 500;
        } elseif ($goal === 'gain_weight') {
            $dcr = $tdee + 500;
        } else {
            $dcr = $tdee;
        }

        $profile = UserProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'age'               => $age,
                'gender'            => $gender,
                'weight_kg'         => $weight,
                'height_cm'         => $height,
                'activity_level'    => $validatedData['activity_level'],
                'goal'              => $goal,
                'bmr'               => round($bmr, 2),
                'tdee_value'        => round($tdee, 2),
                'dcr_value'         => round($dcr, 2),
                'allergies'         => $validatedData['allergies'] ?? null,
                'preferred_cuisine' => $validatedData['preferred_cuisine'] ?? null,
            ]
        );

        // ... (Keep the rest of your meal recommendation logic)
        return redirect()->route('dashboard'); // Or return the view as you did before
    }

    private function getPersonalizedMeal($mealTime, $calorieLimit, $userAllergies, $userCuisine)
    {
        // ... (Keep your existing hybrid algorithm here)
        $query = Meal::where('meal_time', $mealTime)
                     ->where('calories', '<=', $calorieLimit);

        foreach ($userAllergies as $allergy) {
            if (!empty($allergy)) {
                $query->where('ingredients', 'NOT LIKE', '%' . $allergy . '%');
            }
        }

        $safeMeals = $query->get();

        if ($safeMeals->isEmpty()) {
            return null;
        }

        $rankedMeals = $safeMeals->map(function ($meal) use ($userCuisine) {
            $score = 0;
            if ($userCuisine && $meal->cuisine_type === $userCuisine) {
                $score += 10;
            }
            $score += ($meal->calories * 0.01);
            $meal->recommendation_score = $score;
            return $meal;
        });

        return $rankedMeals->sortByDesc('recommendation_score')->first();
    }
}