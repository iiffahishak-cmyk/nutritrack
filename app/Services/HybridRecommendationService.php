<?php

namespace App\Services;

use App\Models\Meal;
use App\Models\MealRating;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Collection;

class HybridRecommendationService
{
    private const RATING_THRESHOLD = 5;

    public function recommend(User $user, string $mealTime, int $limit = 3, array $excludeMealIds = []): array
    {
        $profile = $user->profile;

        if (! $profile) {
            return [
                'method' => 'none',
                'meals' => collect(),
                'slot_budget' => 0,
            ];
        }

        $dcr = $this->calculateDCR($profile);
        $slotBudget = $this->getSlotBudget($dcr, $mealTime);

        $ratingCount = MealRating::where('user_id', $user->id)->count();

        $method = $ratingCount >= self::RATING_THRESHOLD
            ? 'rating-supported'
            : 'profile-based';

        $allergies = $this->getAllergyList($profile);

        /*
        |--------------------------------------------------------------------------
        | Candidate meals
        |--------------------------------------------------------------------------
        */
        $query = Meal::where('meal_time', $mealTime);

        if (! empty($excludeMealIds)) {
            $query->whereNotIn('meal_id', $excludeMealIds);
        }

        $candidateMeals = $query->get();

        /*
        |--------------------------------------------------------------------------
        | Fallback if excluded meals remove everything
        |--------------------------------------------------------------------------
        */
        if ($candidateMeals->isEmpty() && ! empty($excludeMealIds)) {
            $candidateMeals = Meal::where('meal_time', $mealTime)->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Allergy filtering
        |--------------------------------------------------------------------------
        */
        $candidateMeals = $this->removeAllergyRiskMeals($candidateMeals, $allergies);

        /*
        |--------------------------------------------------------------------------
        | Final fallback if allergy filtering removes everything
        |--------------------------------------------------------------------------
        */
        if ($candidateMeals->isEmpty()) {
            $fallbackMeals = Meal::where('meal_time', $mealTime)
                ->inRandomOrder()
                ->take($limit)
                ->get();

            $fallbackMeals = $fallbackMeals->map(function ($meal) {
                $meal->recommendation_score = 25;
                $meal->recommendation_reason = 'Recommended as a fallback option because there are limited matching meals.';
                return $meal;
            });

            return [
                'method' => $method,
                'meals' => $fallbackMeals,
                'slot_budget' => $slotBudget,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Score meals
        |--------------------------------------------------------------------------
        */
        $scoredMeals = $candidateMeals->map(function ($meal) use ($profile, $slotBudget, $method) {
            $score = 0;
            $reasons = [];

            $calories = (float) ($meal->calories ?? 0);
            $calorieDiff = abs($calories - $slotBudget);
            $caloriePercentDiff = $slotBudget > 0 ? $calorieDiff / $slotBudget : 1;

            if ($caloriePercentDiff <= 0.10) {
                $score += 40;
                $reasons[] = 'is very close to your calorie target';
            } elseif ($caloriePercentDiff <= 0.20) {
                $score += 30;
                $reasons[] = 'is close to your calorie target';
            } elseif ($caloriePercentDiff <= 0.30) {
                $score += 20;
                $reasons[] = 'is within a reasonable calorie range';
            } else {
                $score += 8;
            }

            if (
                $profile->preferred_cuisine &&
                strtolower($meal->cuisine_type ?? '') === strtolower($profile->preferred_cuisine)
            ) {
                $score += 35;
                $reasons[] = 'matches your preferred cuisine';
            }

            if (($meal->protein ?? 0) >= 20) {
                $score += 15;
                $reasons[] = 'has good protein content';
            } elseif (($meal->protein ?? 0) >= 10) {
                $score += 8;
            }

            if ($method === 'rating-supported') {
                $avgRating = MealRating::where('meal_id', $meal->meal_id)->avg('rating');

                if ($avgRating >= 4) {
                    $score += 10;
                    $reasons[] = 'has positive user rating feedback';
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Small random value
            |--------------------------------------------------------------------------
            | This helps refresh feel different when multiple meals have similar scores.
            */
            $score += random_int(0, 10) / 10;

            $meal->recommendation_score = min(100, round($score, 1));

            $meal->recommendation_reason = count($reasons)
                ? 'Recommended because it ' . implode(' and ', array_slice($reasons, 0, 2)) . '.'
                : 'Recommended as a suitable option for this meal time.';

            return $meal;
        });

        /*
        |--------------------------------------------------------------------------
        | Rank and return
        |--------------------------------------------------------------------------
        */
        $rankedMeals = $scoredMeals
            ->sortByDesc(function ($meal) {
                return sprintf(
                    '%08.2f-%08.2f-%08d',
                    $meal->recommendation_score ?? 0,
                    $meal->protein ?? 0,
                    random_int(1, 999999)
                );
            })
            ->values()
            ->take($limit);

        return [
            'method' => $method,
            'meals' => $rankedMeals,
            'slot_budget' => $slotBudget,
        ];
    }

    public function calculateDCR(UserProfile $profile): float
    {
        $gender = strtolower($profile->gender ?? 'female');

        $bmr = $gender === 'male'
            ? (10 * $profile->weight_kg) + (6.25 * $profile->height_cm) - (5 * $profile->age) + 5
            : (10 * $profile->weight_kg) + (6.25 * $profile->height_cm) - (5 * $profile->age) - 161;

        $activityFactors = [
            'sedentary' => 1.2,
            'lightly_active' => 1.375,
            'moderately_active' => 1.55,
            'very_active' => 1.725,
            'extra_active' => 1.9,
        ];

        $tdee = $bmr * ($activityFactors[$profile->activity_level] ?? 1.2);

        return match ($profile->goal) {
            'lose', 'lose_weight' => max(800, $tdee - 500),
            'gain', 'gain_weight' => $tdee + 500,
            default => $tdee,
        };
    }

    public function getSlotBudget(float $dcr, string $slot): float
    {
        $percentages = [
            'Breakfast' => 0.25,
            'Lunch' => 0.35,
            'Dinner' => 0.25,
            'Snack' => 0.15,
        ];

        return $dcr * ($percentages[$slot] ?? 0.25);
    }

    private function getAllergyList(UserProfile $profile): Collection
    {
        return collect(explode(',', strtolower($profile->allergies ?? '')))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values();
    }

    private function removeAllergyRiskMeals(Collection $meals, Collection $allergies): Collection
    {
        if ($allergies->isEmpty()) {
            return $meals->values();
        }

        return $meals->filter(function ($meal) use ($allergies) {
            $searchText = strtolower(
                ($meal->meal_name ?? '') . ' ' .
                ($meal->description ?? '') . ' ' .
                ($meal->ingredients ?? '') . ' ' .
                ($meal->allergens ?? '')
            );

            foreach ($allergies as $allergy) {
                if ($allergy !== '' && str_contains($searchText, $allergy)) {
                    return false;
                }
            }

            return true;
        })->values();
    }
}