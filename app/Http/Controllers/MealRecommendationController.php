<?php
namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\UserProfile;
use App\Models\DailyRecommendation;
use App\Models\RecommendationItem;
use App\Models\MealLog; 
use App\Services\MealImageService; // <--- INI WAJIB ADA
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; 

class MealRecommendationController extends Controller
{
    protected $imageService;

    // Masukkan MealImageService dalam constructor
    public function __construct(MealImageService $imageService)
    {
        $this->imageService = $imageService;
    }
public function index()
    {
        $profile = UserProfile::where('user_id', Auth::id())->first();

        if (!$profile) {
            return redirect()->route('profile.index')
                             ->with('error', 'Please complete your profile first to get meal recommendations.');
        }

        $dcr = $profile->dcr_value;

        $limits = [
            'Breakfast' => $dcr * 0.25,
            'Lunch'     => $dcr * 0.35,
            'Dinner'    => $dcr * 0.25,
            'Snack'     => $dcr * 0.15,
        ];

        $userAllergies = $profile->allergies
            ? array_map('trim', explode(',', $profile->allergies))
            : [];
        $userCuisine = $profile->preferred_cuisine;

        $meals = [];
        
        // ---> FOREACH BERMULA DI SINI <---
        foreach ($limits as $time => $limit) {
            
            // 1. Dapatkan makanan dari database
            $meal = $this->getPersonalizedMeal($time, $limit, $userAllergies, $userCuisine);
            
            // 2. Semak dan panggil Pexels API kalau gambar tak ada
            if ($meal && empty($meal->getRawOriginal('image_url'))) {
                $newImageUrl = $this->imageService->fetchImageUrl($meal->meal_name);
                if ($newImageUrl) {
                    // Simpan URL gambar ke database secara terus (abaikan markah sementara)
                    \App\Models\Meal::where('meal_id', $meal->meal_id)->update([
                        'image_url' => $newImageUrl
                    ]);
                    
                    // Kemaskini data untuk dipaparkan di skrin (view)
                    $meal->image_url = $newImageUrl;
                }
            }

            // 3. Masukkan dalam senarai menu
            $meals[$time] = $meal;
            
        } // ---> FOREACH TAMAT DI SINI <---

        $this->saveRecommendation($profile, $meals, $dcr);
        $groceryList = $this->buildGroceryList($meals);
        $macros = $this->calculateMacros($meals);

        return view('meals.recommend', compact(
            'profile', 'meals', 'limits',
            'groceryList', 'macros', 'dcr'
        ));
    }

    private function getPersonalizedMeal($mealTime, $calorieLimit, $userAllergies, $userCuisine)
    {
        $query = Meal::where('meal_time', $mealTime);

        foreach ($userAllergies as $allergy) {
            if (!empty($allergy)) {
                $query->where('ingredients', 'NOT LIKE', '%' . $allergy . '%');
            }
        }

        $preferredQuery = clone $query;

        if (!empty($userCuisine)) {
            $preferredQuery->where('cuisine_type', $userCuisine);
        }

        $safeMeals = !empty($userCuisine)
            ? (clone $preferredQuery)->where('calories', '<=', $calorieLimit)->get()
            : (clone $query)->where('calories', '<=', $calorieLimit)->get();

        if ($safeMeals->isEmpty() && !empty($userCuisine)) {
            $safeMeals = $preferredQuery->orderBy('calories', 'asc')->limit(5)->get();
        }

        if ($safeMeals->isEmpty()) {
            $safeMeals = $query->orderBy('calories', 'asc')->limit(5)->get();
        }

        if ($safeMeals->isEmpty()) {
            return null;
        }

        $rankedMeals = $safeMeals->map(function ($meal) use ($userCuisine, $calorieLimit) {
            $score = 0;
            if ($userCuisine && $meal->cuisine_type === $userCuisine) {
                $score += 50; 
            }
            $calorieDiff = abs($meal->calories - $calorieLimit);
            $score -= ($calorieDiff * 0.1); 
            $meal->recommendation_score = $score;
            return $meal;
        });

        return $rankedMeals->sortByDesc('recommendation_score')->first();
    }

    private function saveRecommendation($profile, $meals, $dcr)
    {
        $recommendation = DailyRecommendation::updateOrCreate(
            [
                'user_id'  => Auth::id(),
                'for_date' => now()->toDateString(),
            ],
            ['total_calories_target' => round($dcr, 2)]
        );

        $recommendation->items()->delete();

        foreach ($meals as $time => $meal) {
            if ($meal) {
                RecommendationItem::create([
                    'recommendation_id' => $recommendation->recommendation_id,
                    'meal_id'           => $meal->meal_id,
                    'suggested_time'    => $time,
                ]);
            }
        }
    }

    private function buildGroceryList($meals)
    {
        $allIngredients = [];

        foreach ($meals as $meal) {
            if ($meal && $meal->ingredients) {
                $items = array_map('trim', explode(',', $meal->ingredients));
                foreach ($items as $item) {
                    if (!empty($item)) {
                        $allIngredients[] = ucfirst(strtolower($item));
                    }
                }
            }
        }

        $allIngredients = array_unique($allIngredients);
        sort($allIngredients);

        return $allIngredients;
    }

    private function calculateMacros($meals)
    {
        $totals = ['protein' => 0, 'carbs' => 0, 'fat' => 0, 'calories' => 0];

        foreach ($meals as $meal) {
            if ($meal) {
                $totals['protein']  += $meal->protein;
                $totals['carbs']    += $meal->carbs;
                $totals['fat']      += $meal->fat;
                $totals['calories'] += $meal->calories;
            }
        }

        return array_map(fn($v) => round($v, 1), $totals);
    }

    public function save(Request $request)
    {
        try {
            $mealId = $request->input('meal_id');
            
            MealLog::create([
                'user_id' => Auth::id(),
                'meal_id' => $mealId,
                'log_date' => now()->toDateString(),
                'meal_time' => $request->input('meal_time'),
            ]);

            return response()->json(['success' => true, 'message' => 'Saved!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
