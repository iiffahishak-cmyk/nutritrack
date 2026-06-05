<?php

// ============================================================
//  database/migrations/xxxx_create_meal_ratings_table.php
//
//  Run:  php artisan make:migration create_meal_ratings_table
//  Then replace the up() / down() with the code below.
// ============================================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the meal_ratings table.
     *
     * Each row = one user rating one meal (1–5 stars).
     * A user can only rate each meal once (unique constraint).
     */
    public function up(): void
    {
        Schema::create('meal_ratings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();     // rating disappears when user is deleted

            $table->foreignId('meal_id')
                  ->constrained('meals', 'meal_id')
                  ->cascadeOnDelete();     // rating disappears when meal is deleted

            // Star rating 1–5 (tinyInteger saves space, CHECK enforced in PHP)
            $table->tinyInteger('rating')
                  ->unsigned()
                  ->comment('1 = terrible, 5 = excellent');

            // Optional free-text review
            $table->text('review')->nullable();

            // Prevent a user from rating the same meal twice
            $table->unique(['user_id', 'meal_id'], 'unique_user_meal_rating');

            $table->timestamps();

            // ── Indexes for query performance ──────────────────────────────
            // Collaborative filtering reads many rows per user and per meal
            $table->index('user_id', 'idx_ratings_user');
            $table->index('meal_id', 'idx_ratings_meal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_ratings');
    }
};