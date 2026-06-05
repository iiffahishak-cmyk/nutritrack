<?php

use Illuminate\Support\Facades\Route;

// Import Semua Controller
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\MealRecommendationController;
use App\Http\Controllers\FoodLoggerController;
use App\Http\Controllers\HybridRecommendationController;
use App\Http\Controllers\WeeklyMealController;
use App\Http\Controllers\MealLogController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\GuestQuizController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RecommendationTestController;


use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// Admin Controllers
use App\Http\Controllers\Admin\MealController as AdminMealController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SpoonacularController;
use App\Http\Controllers\Admin\MealController;
// ─────────────────────────────────────────────────────────
// GUEST / PUBLIC ROUTES
// ─────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

Route::get('/quiz', [GuestQuizController::class, 'showQuiz'])->name('guest.quiz');
Route::post('/quiz/calculate', [GuestQuizController::class, 'calculate'])->name('guest.calculate');
Route::get('/quiz/results', [GuestQuizController::class, 'showResults'])->name('guest.results');

// ─────────────────────────────────────────────────────────
// USER ROUTES (MUST BE LOGGED IN)
// ─────────────────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard (Logic Admin vs User)
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard'); 
        }
        return view('dashboard'); 
    })->name('dashboard');

    Route::view('/nutrition-guide', 'nutrition-guide')->name('nutrition-guide');
    Route::post('/meals/save-many', [MealLogController::class, 'saveMany'])
    ->name('meals.save-many');

    // ── PROFILE ─────────────────────────────────────────
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.index');
    Route::post('/profile', [UserProfileController::class, 'calculateAndSaveProfile'])->name('profile.save');
   Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/weight', [UserProfileController::class, 'updateWeight'])->name('profile.weight');

    // ── DIARY & LOGGING ──────────────────────────────────
    Route::get('/my-diary', [DiaryController::class, 'index'])->name('diary.index');
    Route::get('/meals/diary', [DiaryController::class, 'index'])->name('meals.diary');
    Route::get('/food-logger', [FoodLoggerController::class, 'index'])->name('food-logger.index');
    Route::post('/food-logger/analyze', [FoodLoggerController::class, 'analyze'])->name('food-logger.analyze');
    Route::post('/food-logger/save', [FoodLoggerController::class, 'save'])->name('food-logger.save');

    // ── RECOMMENDATIONS ──────────────────────────────────
    // Basic Recommendation
    Route::get('/meals/recommend', [MealRecommendationController::class, 'index'])->name('meals.recommend');

    // Hybrid Recommendation (Sistem yang lebih canggih)
    Route::get('/meals/hybrid-recommend', [HybridRecommendationController::class, 'index'])->name('meals.hybrid-recommend');
    Route::get('/meals/hybrid-recommend/single', [HybridRecommendationController::class, 'single'])->name('meals.hybrid-recommend.single');
    
    // Actions: Rate & Save (Ikut Original: MealLogController uruskan Save)
    Route::post('/meals/rate', [HybridRecommendationController::class, 'rate'])->name('meals.rate');
    Route::delete('/meals/rate/{meal_id}', [HybridRecommendationController::class, 'deleteRating'])->name('meals.rate.delete');
    
    // SAVE ROUTE (Satu sahaja untuk elak error "Could not connect")
    Route::post('/meals/save', [MealLogController::class, 'save'])->name('meals.save');
    Route::post('/meals/save-plan', [MealLogController::class, 'save'])->name('meals.save-plan');
    Route::delete('/meals/log/{id}', [MealLogController::class, 'destroy'])->name('meals.log.destroy');

    // ── WEEKLY PLAN ─────────────────────────────────────
    Route::get('/meals/weekly', [WeeklyMealController::class, 'index'])->name('meals.weekly');
    Route::post('/meals/weekly/generate', [WeeklyMealController::class, 'generate'])->name('meals.weekly.generate');
    Route::post('/meals/weekly/swap', [WeeklyMealController::class, 'swap'])->name('meals.weekly.swap');

});

// ─────────────────────────────────────────────────────────
// ADMIN ROUTES
// ─────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

      Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::post('/meals/{meal}/fetch-image', [\App\Http\Controllers\Admin\MealController::class, 'fetchImage'])
    ->name('meals.fetch-image');
    
Route::match(['get', 'post'], '/recommendation-test', [RecommendationTestController::class, 'index'])
    ->name('recommendation-test.index');
    
        Route::resource('meals', AdminMealController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('users', AdminUserController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
        Route::delete('users/{id}/profile', [AdminUserController::class, 'destroyProfile'])->name('users.destroyProfile');

     Route::get('/spoonacular', [SpoonacularController::class, 'index'])
    ->name('spoonacular.index');

Route::post('/spoonacular/import', [SpoonacularController::class, 'import'])
    ->name('spoonacular.import');

Route::post('/spoonacular/import-profile', [SpoonacularController::class, 'importProfile'])
    ->name('spoonacular.import-profile');

Route::post('/spoonacular/import-single', [SpoonacularController::class, 'importSingle'])
    ->name('spoonacular.import-single');

Route::get('/food-items', [SpoonacularController::class, 'listItems'])
    ->name('food-items.index');

Route::patch('/food-items/verify-all-pending', [SpoonacularController::class, 'verifyAll'])
    ->name('food-items.verify-all');

Route::patch('/food-items/{id}/verify', [SpoonacularController::class, 'verify'])
    ->name('food-items.verify');

Route::patch('/food-items/{id}/toggle', [SpoonacularController::class, 'toggleActive'])
    ->name('food-items.toggle-active');

Route::delete('/food-items/{id}', [SpoonacularController::class, 'destroy'])
    ->name('food-items.destroy');
    });

require __DIR__ . '/auth.php';
