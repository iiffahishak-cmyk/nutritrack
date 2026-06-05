<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weekly_meal_plans', function (Blueprint $table) {
            $table->id();
            
            // Links the plan to a specific user
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Tracks the specific week and day
            $table->date('week_start_date');
            $table->integer('day_of_week'); // 1 = Monday, 7 = Sunday
            $table->string('meal_time'); // Breakfast, Lunch, Dinner, Snack
            
            // The actual meal assigned
            $table->unsignedBigInteger('meal_id'); 
            
            // Calorie goal for this specific meal slot
            $table->integer('calories_target');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weekly_meal_plans');
    }
};