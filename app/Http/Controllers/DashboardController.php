<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MealLog; // You will create this model next
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->first();

        // 1. Fetch today's saved meals for history
        $savedMeals = MealLog::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->orderByDesc('created_at')
            ->get();

        // 2. Calculate totals for your progress bars
        $totalCal  = $savedMeals->sum('calories');
        $totalPro  = $savedMeals->sum('protein');
        $totalCarb = $savedMeals->sum('carbs');
        $totalFat  = $savedMeals->sum('fat');

        // 3. Send everything to the view
        return view('profile.index', compact(
            'profile', 
            'savedMeals', 
            'totalCal', 
            'totalPro', 
            'totalCarb', 
            'totalFat'
        ));
    }
}