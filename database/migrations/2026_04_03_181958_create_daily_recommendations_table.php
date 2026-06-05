<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Main recommendation record per user per day
        Schema::create('daily_recommendations', function (Blueprint $table) {
            $table->id('recommendation_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('for_date');                          // fixed: was 'recommendation_date'
            $table->decimal('total_calories_target', 8, 2);   // added: stores DCR for that day
            $table->timestamps();
        });

        // Each individual meal inside a recommendation
        Schema::create('recommendation_items', function (Blueprint $table) { // added: was missing entirely
            $table->id('item_id');
            $table->unsignedBigInteger('recommendation_id');
            $table->unsignedBigInteger('meal_id');
            $table->enum('suggested_time', ['Breakfast', 'Lunch', 'Dinner', 'Snack']);
            $table->timestamps();

            $table->foreign('recommendation_id')
                  ->references('recommendation_id')
                  ->on('daily_recommendations')
                  ->onDelete('cascade');

            $table->foreign('meal_id')
                  ->references('meal_id')
                  ->on('meals')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendation_items');
        Schema::dropIfExists('daily_recommendations');
    }
};