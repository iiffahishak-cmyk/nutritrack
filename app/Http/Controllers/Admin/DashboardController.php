<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyRecommendation;
use App\Models\FoodItem;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMeals = Meal::count();

        /*
         * Count normal users only.
         * If your users table stores role as "user", this is correct.
         */
        $totalUsers = User::where('role', 'user')->count();

        $newUsersThisWeek = User::where('role', 'user')
            ->where('created_at', '>=', now()->startOfWeek())
            ->count();

        $recentUsers = User::where('role', 'user')
            ->latest()
            ->take(5)
            ->get();

        $recentMeals = Meal::latest()
            ->take(5)
            ->get();

        /*
         * Count today's generated daily recommendations.
         * If this table is still empty, Today’s Plans will correctly show 0.
         */
        $totalRecommendations = DailyRecommendation::whereDate('for_date', today())->count();

        /*
         * Meal time coverage.
         * This handles normal values such as Breakfast, Lunch, Dinner, Snack.
         */
        $rawTimeCounts = Meal::selectRaw('TRIM(meal_time) as meal_time, COUNT(*) as total')
            ->whereNotNull('meal_time')
            ->groupBy(DB::raw('TRIM(meal_time)'))
            ->pluck('total', 'meal_time');

        $mealsByTime = [
            'Breakfast' => $this->findCount($rawTimeCounts, ['Breakfast', 'breakfast']),
            'Lunch'     => $this->findCount($rawTimeCounts, ['Lunch', 'lunch']),
            'Dinner'    => $this->findCount($rawTimeCounts, ['Dinner', 'dinner']),
            'Snack'     => $this->findCount($rawTimeCounts, ['Snack', 'snack']),
        ];

        /*
         * Cuisine coverage.
         * IMPORTANT:
         * International is NOT counted as Middle Eastern.
         * If meals are still International, they must be reviewed and edited manually.
         */
        $rawCuisineCounts = Meal::selectRaw('TRIM(cuisine_type) as cuisine_type, COUNT(*) as total')
            ->whereNotNull('cuisine_type')
            ->groupBy(DB::raw('TRIM(cuisine_type)'))
            ->pluck('total', 'cuisine_type');

        $mealsByCuisine = [
            'Malay'          => $this->findCount($rawCuisineCounts, ['Malay', 'malay']),
            'Chinese'        => $this->findCount($rawCuisineCounts, ['Chinese', 'chinese']),
            'Indian'         => $this->findCount($rawCuisineCounts, ['Indian', 'indian']),
            'Western'        => $this->findCount($rawCuisineCounts, ['Western', 'western']),
            'Middle Eastern' => $this->findCount($rawCuisineCounts, ['Middle Eastern', 'middle eastern', 'Middle-Eastern', 'middle-eastern']),
        ];

        $foodItemStats = [
            'total'    => class_exists(FoodItem::class) ? FoodItem::count() : 0,
            'pending'  => class_exists(FoodItem::class) ? FoodItem::where('is_verified', false)->count() : 0,
            'verified' => class_exists(FoodItem::class) ? FoodItem::where('is_verified', true)->count() : 0,
        ];

        return view('admin.dashboard', compact(
            'totalMeals',
            'totalUsers',
            'totalRecommendations',
            'newUsersThisWeek',
            'recentUsers',
            'recentMeals',
            'mealsByTime',
            'mealsByCuisine',
            'foodItemStats'
        ));
    }

    private function findCount($collection, array $possibleNames): int
    {
        foreach ($possibleNames as $name) {
            if (isset($collection[$name])) {
                return (int) $collection[$name];
            }
        }

        return 0;
    }
}