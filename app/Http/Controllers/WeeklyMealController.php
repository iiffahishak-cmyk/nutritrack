<?php

// ============================================================
//  app/Http/Controllers/WeeklyMealController.php
//
//  FIXES:
//  1. WeeklyMealPlan::weekStart() now returns string — no more
//     Carbon::parse() wrapper needed (was causing date mismatch)
//  2. $plans variable renamed consistently to $rawPlans
//  3. isSameWeek() fixed to use consistent MONDAY start
// ============================================================

namespace App\Http\Controllers;

use App\Models\WeeklyMealPlan;
use App\Services\HybridRecommendationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WeeklyMealController extends Controller
{
    public function __construct(
        private readonly HybridRecommendationService $recommender
    ) {}

    // ─────────────────────────────────────────────────────────────────────
    //  GET /meals/weekly[?week=YYYY-MM-DD]
    // ─────────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $user    = Auth::user()->load('profile');
        $profile = $user->profile;

        if (! $profile) {
            return redirect()->route('profile.index')
                ->with('warning', 'Please complete your health profile first.');
        }

        // Determine which Monday to show
        $anchor    = $request->filled('week')
                        ? Carbon::parse($request->week)
                        : Carbon::now();

        // weekStart() returns a string like '2026-05-04'
        $weekStartStr = WeeklyMealPlan::weekStart($anchor);
        $weekStart    = Carbon::parse($weekStartStr);
        $weekEnd      = $weekStart->copy()->endOfWeek(Carbon::SUNDAY);

        // Is this the current week?
        $currentWeekStr = WeeklyMealPlan::weekStart(Carbon::now());
        $isCurrentWeek  = $weekStartStr === $currentWeekStr;

        // Load saved plans for this week with their meals
        $rawPlans = WeeklyMealPlan::where('user_id', $user->id)
            ->where('week_start_date', $weekStartStr)
            ->with('meal')   // uses the FIXED belongsTo with ownerKey='meal_id'
            ->get();

        // Build planGrid[day_of_week][meal_time] = WeeklyMealPlan
        $planGrid = [];
        foreach ($rawPlans as $plan) {
            $planGrid[$plan->day_of_week][$plan->meal_time] = $plan;
        }

        // Build day metadata for all 7 days of this week
        $days = [];
        for ($d = 1; $d <= 7; $d++) {
            $carbon = $weekStart->copy()->addDays($d - 1);
            $days[$d] = [
                'carbon'  => $carbon,
                'label'   => $carbon->format('D'),     // Mon, Tue…
                'date'    => $carbon->format('d M'),   // 04 May
                'isToday' => $carbon->isToday(),
            ];
        }

        $dcr      = $this->recommender->calculateDCR($profile);
        $prevWeek = $weekStart->copy()->subWeek()->toDateString();
        $nextWeek = $weekStart->copy()->addWeek()->toDateString();
        $canGoNext = $weekStart->copy()->addWeek()->lte(Carbon::now()->startOfWeek(Carbon::MONDAY));

        // Build past 6 weeks for sidebar history
        $pastWeeks = [];
        for ($w = 0; $w <= 5; $w++) {
            $ws = Carbon::now()->startOfWeek(Carbon::MONDAY)->subWeeks($w);
            $we = $ws->copy()->endOfWeek(Carbon::SUNDAY);
            $wsStr = $ws->toDateString();
            $pastWeeks[] = [
                'start'     => $ws,
                'end'       => $we,
                'hasPlans'  => WeeklyMealPlan::where('user_id', $user->id)
                                              ->where('week_start_date', $wsStr)
                                              ->exists(),
                'isCurrent' => $wsStr === $weekStartStr,
            ];
        }

        // Pass $plans for backward compatibility with blade ($plans->count())
        return view('meals.weekly', [
            'planGrid'      => $planGrid,
            'days'          => $days,
            'weekStart'     => $weekStart,
            'weekEnd'       => $weekEnd,
            'isCurrentWeek' => $isCurrentWeek,
            'dcr'           => $dcr,
            'profile'       => $profile,
            'prevWeek'      => $prevWeek,
            'nextWeek'      => $nextWeek,
            'canGoNext'     => $canGoNext,
            'plans'         => $rawPlans,   // blade uses $plans->count()
            'rawPlans'      => $rawPlans,
            'pastWeeks'     => $pastWeeks,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────
    //  POST /meals/weekly/generate
    //  Generates 7 days × 4 slots = up to 28 meal entries.
    //  Uses updateOrCreate so re-generating is safe (no duplicates).
    // ─────────────────────────────────────────────────────────────────────
    public function generate(Request $request)
{
    $user    = Auth::user()->load('profile');
    $profile = $user->profile;

    if (! $profile) {
        return back()->with('error', 'Health profile required.');
    }

    $weekStartStr = WeeklyMealPlan::weekStart(Carbon::now());
    $slots        = ['Breakfast', 'Lunch', 'Dinner', 'Snack'];
    $dcr          = $this->recommender->calculateDCR($profile);
    $saved        = 0;

    $usedMealIds = [];

    foreach ($slots as $slot) {
        $result = $this->recommender->recommend(
            user: $user,
            mealTime: $slot,
            limit: 14,
        );

        $candidates = $result['meals'];

        if ($candidates->isEmpty()) {
            continue;
        }

        $candidates = $candidates->shuffle()->values();

        for ($day = 1; $day <= 7; $day++) {
            $meal = $candidates
                ->filter(function ($candidate) use ($usedMealIds) {
                    $id = $candidate->meal_id ?? $candidate->id;
                    return ! in_array((int) $id, $usedMealIds, true);
                })
                ->first();

            if (! $meal) {
                $meal = $candidates->get(($day - 1) % $candidates->count());
            }

            if (! $meal) {
                continue;
            }

            $mealId = $meal->meal_id ?? $meal->id;
            $usedMealIds[] = (int) $mealId;

            WeeklyMealPlan::updateOrCreate(
                [
                    'user_id'         => $user->id,
                    'week_start_date' => $weekStartStr,
                    'day_of_week'     => $day,
                    'meal_time'       => $slot,
                ],
                [
                    'meal_id'         => $mealId,
                    'calories_target' => (int) $this->recommender->getSlotBudget($dcr, $slot),
                ]
            );

            $saved++;
        }
    }

    return redirect()->route('meals.weekly')
        ->with('success', "Weekly plan generated — {$saved} meals planned across 7 days.");
}

    // ─────────────────────────────────────────────────────────────────────
    //  POST /meals/weekly/swap  (AJAX)
    //  Replace one slot with a different meal from the recommender.
    // ─────────────────────────────────────────────────────────────────────
    public function swap(Request $request)
    {
        $v = $request->validate([
            'day_of_week'     => ['required', 'integer', 'min:1', 'max:7'],
            'meal_time'       => ['required', Rule::in(['Breakfast','Lunch','Dinner','Snack'])],
            'current_meal_id' => ['required', 'integer'],
        ]);

        $user         = Auth::user()->load('profile');
        $weekStartStr = WeeklyMealPlan::weekStart(Carbon::now());
        $dcr          = $this->recommender->calculateDCR($user->profile);

        $result = $this->recommender->recommend(
            user:     $user,
            mealTime: $v['meal_time'],
            limit:    10,
        );

        // Pick a meal that isn't the current one
        $alt = $result['meals']
            ->filter(function ($m) use ($v) {
                $id = $m->meal_id ?? $m->id;
                return (int) $id !== (int) $v['current_meal_id'];
            })
            ->first();

        if (! $alt) {
            return response()->json(['success' => false, 'message' => 'No alternative meal found for this slot.']);
        }

        $altMealId = $alt->meal_id ?? $alt->id;

        WeeklyMealPlan::updateOrCreate(
            [
                'user_id'         => $user->id,
                'week_start_date' => $weekStartStr,
                'day_of_week'     => $v['day_of_week'],
                'meal_time'       => $v['meal_time'],
            ],
            [
                'meal_id'         => $altMealId,
                'calories_target' => (int) $this->recommender->getSlotBudget($dcr, $v['meal_time']),
            ]
        );

        return response()->json([
            'success'   => true,
            'meal_name' => $alt->meal_name,
            'calories'  => $alt->calories,
            'protein'   => $alt->protein,
            'carbs'     => $alt->carbs,
            'fat'       => $alt->fat,
            'meal_id'   => $altMealId,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────
    //  POST /meals/weekly/clear
    //  Delete all entries for the current week (start fresh)
    // ─────────────────────────────────────────────────────────────────────
    public function clear()
    {
        $weekStartStr = WeeklyMealPlan::weekStart(Carbon::now());
        $count = WeeklyMealPlan::where('user_id', Auth::id())
                                ->where('week_start_date', $weekStartStr)
                                ->delete();

        return back()->with('success', "Cleared {$count} meals from this week's plan.");
    }
}