<?php

namespace App\Http\Controllers;

use App\Models\MealRating;
use App\Services\HybridRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class HybridRecommendationController extends Controller
{
    public function __construct(
        private readonly HybridRecommendationService $recommender
    ) {}

    public function index(Request $request)
    {
        $user = Auth::user()->load('profile');
        $profile = $user->profile;

        if (! $profile) {
            return redirect()->route('profile.index')
                ->with('warning', 'Please complete your health profile before viewing meal options.');
        }

        $slots = ['Breakfast', 'Lunch', 'Dinner', 'Snack'];
        $recommendations = [];

        /*
        |--------------------------------------------------------------------------
        | Refresh Logic
        |--------------------------------------------------------------------------
        | refresh=timestamp means refresh all meal slots.
        | refresh_slot=Lunch means refresh only Lunch.
        | exclude_ids tells the service which current meals should be avoided.
        */
        $lastIds = session('meal_options_last_ids', []);

        foreach ($slots as $slot) {
            $excludeIds = [];

            if ($request->filled('refresh')) {
                $excludeIds = $lastIds[$slot] ?? [];
            }

            if ($request->filled('refresh_slot') && $request->input('refresh_slot') === $slot) {
                $excludeIds = collect(explode(',', $request->input('exclude_ids', '')))
                    ->map(fn ($id) => (int) trim($id))
                    ->filter()
                    ->values()
                    ->toArray();

                if (empty($excludeIds)) {
                    $excludeIds = $lastIds[$slot] ?? [];
                }
            }

            $recommendations[$slot] = $this->recommender->recommend(
                user: $user,
                mealTime: $slot,
                limit: 3,
                excludeMealIds: $excludeIds
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Store current displayed meal IDs
        |--------------------------------------------------------------------------
        | These will be used during the next refresh.
        */
        $currentIds = [];

        foreach ($recommendations as $slot => $result) {
            $currentIds[$slot] = collect($result['meals'] ?? [])
                ->pluck('meal_id')
                ->filter()
                ->values()
                ->toArray();
        }

        session(['meal_options_last_ids' => $currentIds]);

        $ratingCount = MealRating::where('user_id', $user->id)->count();
        $dcr = $this->recommender->calculateDCR($profile);

        return view('meals.hybrid-recommend', compact(
            'recommendations',
            'ratingCount',
            'dcr',
            'profile'
        ));
    }

    public function rate(Request $request)
    {
        $validated = $request->validate([
            'meal_id' => ['required', 'integer', Rule::exists('meals', 'meal_id')],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['nullable', 'string', 'max:500'],
        ]);

        MealRating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'meal_id' => $validated['meal_id'],
            ],
            [
                'rating' => $validated['rating'],
                'review' => $validated['review'] ?? null,
            ]
        );

        $newCount = MealRating::where('user_id', Auth::id())->count();
        $threshold = 5;
        $remaining = max(0, $threshold - $newCount);

        $message = $remaining > 0
            ? "Rating saved! Rate {$remaining} more meal(s) to unlock rating-supported recommendations."
            : "Rating saved! Rating-supported recommendations are now active.";

        return response()->json([
            'success' => true,
            'message' => $message,
            'rating_count' => $newCount,
            'cf_unlocked' => $newCount >= $threshold,
        ]);
    }

    public function deleteRating(int $mealId)
    {
        MealRating::where('user_id', Auth::id())
            ->where('meal_id', $mealId)
            ->delete();

        return back()->with('success', 'Rating removed.');
    }

    public function single(Request $request)
    {
        $validated = $request->validate([
            'slot' => ['required', Rule::in(['Breakfast', 'Lunch', 'Dinner', 'Snack'])],
            'exclude_ids' => ['nullable', 'string'],
        ]);

        $user = Auth::user()->load('profile');

        if (! $user->profile) {
            return response()->json([
                'success' => false,
                'message' => 'Please complete your health profile first.',
            ], 422);
        }

        $excludeIds = collect(explode(',', $validated['exclude_ids'] ?? ''))
            ->map(fn ($id) => (int) trim($id))
            ->filter()
            ->values()
            ->toArray();

        $result = $this->recommender->recommend(
            user: $user,
            mealTime: $validated['slot'],
            limit: 3,
            excludeMealIds: $excludeIds
        );

        return response()->json([
            'success' => true,
            'slot' => $validated['slot'],
            'method' => $result['method'] ?? 'profile-based',
            'slot_budget' => $result['slot_budget'] ?? 0,
            'meals' => collect($result['meals'] ?? [])->map(function ($m) {
                return [
                    'meal_id' => $m->meal_id,
                    'meal_name' => $m->meal_name,
                    'calories' => $m->calories,
                    'protein' => $m->protein,
                    'carbs' => $m->carbs,
                    'fat' => $m->fat,
                    'cuisine' => $m->cuisine_type,
                    'score' => $m->recommendation_score ?? 0,
                    'reason' => $m->recommendation_reason ?? 'Recommended as a suitable option for this meal time.',
                ];
            })->values(),
        ]);
    }
}