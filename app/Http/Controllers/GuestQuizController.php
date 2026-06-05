<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestQuizController extends Controller
{
    /**
     * Show the guest starter quiz page.
     */
    public function showQuiz()
    {
        return view('onboarding.quiz');
    }

    /**
     * Calculate guest BMI, BMR, TDEE and DCR, then save all quiz data to session.
     */
    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'gender' => ['required', 'in:male,female'],
            'age' => ['required', 'numeric', 'min:12', 'max:100'],
            'activity_level' => ['required', 'in:sedentary,lightly_active,moderately_active,very_active,extra_active'],
            'goal' => ['required', 'in:lose_weight,maintain,gain_weight'],
            'weight_kg' => ['required', 'numeric', 'min:20', 'max:300'],
            'height_cm' => ['required', 'numeric', 'min:100', 'max:250'],
            'allergies' => ['nullable', 'string', 'max:500'],
            'preferred_cuisine' => ['nullable', 'string', 'max:100'],
        ]);

        $weight = (float) $validated['weight_kg'];
        $height = (float) $validated['height_cm'];
        $age = (int) $validated['age'];
        $gender = $validated['gender'];
        $activityLevel = $validated['activity_level'];
        $goal = $validated['goal'];
        $allergies = trim($validated['allergies'] ?? '');
        $preferredCuisine = trim($validated['preferred_cuisine'] ?? '');

        if ($preferredCuisine === '') {
            $preferredCuisine = 'No preference';
        }

        /**
         * BMI calculation
         * BMI = weight / height(m)^2
         */
        $heightMeter = $height / 100;
        $bmi = $weight / ($heightMeter * $heightMeter);

        /**
         * BMR calculation using Mifflin-St Jeor Equation.
         */
        if ($gender === 'male') {
            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) + 5;
        } else {
            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;
        }

        /**
         * TDEE calculation based on activity level.
         */
        $multipliers = [
            'sedentary' => 1.2,
            'lightly_active' => 1.375,
            'moderately_active' => 1.55,
            'very_active' => 1.725,
            'extra_active' => 1.9,
        ];

        $tdee = $bmr * ($multipliers[$activityLevel] ?? 1.2);

        /**
         * DCR calculation based on user goal.
         */
        $dcr = match ($goal) {
            'lose_weight' => $tdee - 500,
            'gain_weight' => $tdee + 500,
            default => $tdee,
        };

        /**
         * Healthy weight range based on BMI 18.5 to 24.9.
         */
        $healthyMin = 18.5 * ($heightMeter * $heightMeter);
        $healthyMax = 24.9 * ($heightMeter * $heightMeter);

        /**
         * Save ALL quiz data to session.
         * Important:
         * - Use both old keys and database-style keys for compatibility.
         * - preferred_cuisine and allergies are now included.
         */
        session([
            'guest_data' => [
                // Basic user inputs
                'gender' => $gender,
                'age' => $age,
                'weight' => round($weight, 2),
                'height' => round($height, 2),
                'weight_kg' => round($weight, 2),
                'height_cm' => round($height, 2),
                'activity_level' => $activityLevel,
                'goal' => $goal,
                'allergies' => $allergies,
                'preferred_cuisine' => $preferredCuisine,

                // Calculated values
                'bmi' => round($bmi, 2),
                'bmr' => round($bmr, 2),
                'tdee' => round($tdee, 2),
                'dcr' => round($dcr, 2),

                // Database-style calculated keys
                'tdee_value' => round($tdee, 2),
                'dcr_value' => round($dcr, 2),

                // Healthy weight range
                'healthy_weight_min' => round($healthyMin, 1),
                'healthy_weight_max' => round($healthyMax, 1),
            ],
        ]);

        return redirect()->route('guest.results');
    }

    /**
     * Show guest result page after quiz calculation.
     */
    public function showResults()
    {
        if (!session()->has('guest_data')) {
            return redirect()->route('guest.quiz');
        }

        $data = session('guest_data');

        return view('onboarding.results', compact('data'));
    }
}