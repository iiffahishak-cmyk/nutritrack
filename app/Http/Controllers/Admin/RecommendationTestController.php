<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Http\Request;

class RecommendationTestController extends Controller
{
    public function index(Request $request)
    {
        $results = collect();
        $summary = null;

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'dcr' => ['required', 'numeric', 'min:800', 'max:5000'],
                'meal_time' => ['required', 'string', 'in:Breakfast,Lunch,Dinner,Snack'],
                'preferred_cuisine' => ['nullable', 'string', 'in:Malay,Chinese,Indian,Western,Middle Eastern'],
                'allergies' => ['nullable', 'string', 'max:255'],
            ]);

            $dcr = (float) $validated['dcr'];
            $mealTime = $validated['meal_time'];
            $preferredCuisine = $validated['preferred_cuisine'] ?? null;
            $allergies = $validated['allergies'] ?? '';

            $slotBudget = $this->getSlotBudget($dcr, $mealTime);

            $allergyList = collect(explode(',', strtolower($allergies)))
                ->map(fn ($item) => trim($item))
                ->filter()
                ->values();

            $meals = Meal::where('meal_time', $mealTime)->get();

            $results = $meals->map(function ($meal) use ($slotBudget, $preferredCuisine, $allergyList) {
                $score = 0;
                $reasons = [];
                $warnings = [];

                $calories = (float) ($meal->calories ?? 0);
                $calorieDiff = abs($calories - $slotBudget);
                $caloriePercentDiff = $slotBudget > 0 ? $calorieDiff / $slotBudget : 1;

                if ($caloriePercentDiff <= 0.10) {
                    $score += 40;
                    $reasons[] = 'Very close to calorie target';
                } elseif ($caloriePercentDiff <= 0.20) {
                    $score += 30;
                    $reasons[] = 'Close to calorie target';
                } elseif ($caloriePercentDiff <= 0.30) {
                    $score += 20;
                    $reasons[] = 'Acceptable calorie range';
                } else {
                    $warnings[] = 'Calories are far from target';
                }

                $cuisineMatched = false;

                if ($preferredCuisine) {
                    $cuisineMatched = strtolower($meal->cuisine_type ?? '') === strtolower($preferredCuisine);

                    if ($cuisineMatched) {
                        $score += 35;
                        $reasons[] = 'Matches preferred cuisine';
                    } else {
                        $warnings[] = 'Cuisine does not match preference';
                    }
                }

                $hasAllergyRisk = false;

                if ($allergyList->isNotEmpty()) {
                    $mealText = strtolower(
                        ($meal->meal_name ?? '') . ' ' .
                        ($meal->description ?? '') . ' ' .
                        ($meal->ingredients ?? '')
                    );

                    foreach ($allergyList as $allergy) {
                        if ($allergy !== '' && str_contains($mealText, $allergy)) {
                            $hasAllergyRisk = true;
                            $warnings[] = "Possible allergy risk: {$allergy}";
                        }
                    }

                    if (! $hasAllergyRisk) {
                        $score += 20;
                        $reasons[] = 'No listed allergy detected';
                    }
                }

                if (($meal->protein ?? 0) >= 20) {
                    $score += 15;
                    $reasons[] = 'High protein';
                } elseif (($meal->protein ?? 0) >= 10) {
                    $score += 8;
                    $reasons[] = 'Moderate protein';
                }

                $meal->test_score = min(100, round($score, 1));
                $meal->test_reason = count($reasons)
                    ? implode(', ', $reasons)
                    : 'Basic match only';

                $meal->test_warnings = $warnings;
                $meal->test_calorie_diff = round($calorieDiff);
                $meal->test_cuisine_matched = $cuisineMatched;
                $meal->test_allergy_risk = $hasAllergyRisk;

                return $meal;
            })
            ->reject(fn ($meal) => $meal->test_allergy_risk)
            ->sortByDesc(function ($meal) {
                return [
                    $meal->test_score,
                    $meal->protein ?? 0,
                    $meal->calories ?? 0,
                    $meal->meal_id ?? 0,
                ];
            })
            ->values()
            ->take(10);

            $summary = [
                'dcr' => $dcr,
                'meal_time' => $mealTime,
                'slot_budget' => $slotBudget,
                'preferred_cuisine' => $preferredCuisine ?: 'No preference',
                'allergies' => $allergies ?: 'None',
                'total_candidates' => $meals->count(),
                'shown_results' => $results->count(),
            ];
        }

        return view('admin.recommendation-test.index', compact('results', 'summary'));
    }

    private function getSlotBudget(float $dcr, string $mealTime): int
    {
        $percentages = [
            'Breakfast' => 0.25,
            'Lunch' => 0.35,
            'Dinner' => 0.25,
            'Snack' => 0.15,
        ];

        return (int) round($dcr * ($percentages[$mealTime] ?? 0.25));
    }
}