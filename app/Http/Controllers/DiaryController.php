<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MealLog; // <-- Change this to whatever your saved meals model is named!
use Illuminate\Support\Carbon;

class DiaryController extends Controller
{
    public function index()
    {
        // 1. Guna nama $savedMeals supaya sepadan dengan diary.blade.php
        $savedMeals = MealLog::where('user_id', auth()->id())
            ->with('meal') // Pastikan ada relationship 'meal' dalam model MealLog
            ->orderBy('created_at', 'desc')
            ->get(); // Buang groupBy supaya table HTML awak boleh baca satu-satu baris dengan mudah

        // 2. Hantar variable yang betul ke view
        return view('meals.diary', compact('savedMeals'));
    }
}