<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class,
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        /**
         * Create the user account.
         */
        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        /**
         * Move starter quiz data from session into the new user's health profile.
         *
         * The starter quiz stores data inside session('guest_data').
         * This block copies the values into user_profiles so the Health Profile page
         * will show the selected goal, activity level, allergies, preferred cuisine,
         * BMR, TDEE, and DCR after registration.
         */
        if (session()->has('guest_data')) {
            $quizData = session('guest_data');

            /**
             * Normalize goal value.
             * Older quiz versions may save "lose" or "gain".
             * New quiz version saves "lose_weight" or "gain_weight".
             */
            $rawGoal = $quizData['goal'] ?? 'maintain';

            $dbGoal = match ($rawGoal) {
                'lose', 'lose_weight' => 'lose_weight',
                'gain', 'gain_weight' => 'gain_weight',
                default => 'maintain',
            };

            /**
             * Normalize preferred cuisine.
             */
            $preferredCuisine = $quizData['preferred_cuisine'] ?? 'No preference';

            if (is_null($preferredCuisine) || trim($preferredCuisine) === '') {
                $preferredCuisine = 'No preference';
            }

            /**
             * Normalize allergies.
             */
            $allergies = $quizData['allergies'] ?? null;

            if (!is_null($allergies)) {
                $allergies = trim($allergies);
            }

            /**
             * Create or update user profile.
             */
            UserProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'age' => $quizData['age'] ?? null,
                    'gender' => $quizData['gender'] ?? 'female',

                    /**
                     * Support both old session keys and new session keys.
                     */
                    'weight_kg' => $quizData['weight_kg'] ?? $quizData['weight'] ?? null,
                    'height_cm' => $quizData['height_cm'] ?? $quizData['height'] ?? null,

                    'activity_level' => $quizData['activity_level'] ?? 'sedentary',
                    'goal' => $dbGoal,
                    'allergies' => $allergies,
                    'preferred_cuisine' => $preferredCuisine,

                    /**
                     * Calculated values.
                     */
                    'bmr' => $quizData['bmr'] ?? 0,
                    'tdee_value' => $quizData['tdee_value'] ?? $quizData['tdee'] ?? 0,
                    'dcr_value' => $quizData['dcr_value'] ?? $quizData['dcr'] ?? 0,
                ]
            );

            /**
             * Clear quiz session after saving to database.
             */
            session()->forget('guest_data');
        }

        Auth::login($user);

        return redirect()->route('profile.index');
    }
}