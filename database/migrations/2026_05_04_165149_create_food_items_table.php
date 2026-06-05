<?php

// ============================================================
//  database/migrations/xxxx_create_food_items_table.php
//
//  Run:
//    php artisan make:migration create_food_items_table
//  Then replace up() / down() with this content.
// ============================================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Schema design notes
     * ───────────────────
     * • spoonacular_id   — prevents duplicate imports; allows re-sync
     * • source           — tracks where the record came from (spoonacular / manual / ai)
     * • calorie_range_*  — the DCR window that was active when this item was fetched
     * • is_verified      — admin approval gate before item appears in recommendations
     * • is_active        — soft-disable without deleting (keeps history intact)
     * • sync_*           — audit trail for every API import
     */
    public function up(): void
    {
        Schema::create('food_items', function (Blueprint $table) {

            // ── Primary key ────────────────────────────────────────────────
            $table->id();                                   // auto-increment BIGINT

            // ── External reference ─────────────────────────────────────────
            $table->unsignedBigInteger('spoonacular_id')
                  ->nullable()
                  ->unique()
                  ->comment('Spoonacular recipe/ingredient ID — prevents duplicate imports');

            // ── Core meal data ─────────────────────────────────────────────
            $table->string('meal_name', 255);
            $table->text('description')->nullable();
            $table->string('image_url', 500)->nullable();

            // ── Nutritional data (per serving) ─────────────────────────────
            $table->unsignedSmallInteger('calories')
                  ->comment('kcal per serving');

            $table->decimal('protein_g', 7, 2)->default(0)
                  ->comment('Protein in grams per serving');

            $table->decimal('carbs_g',   7, 2)->default(0)
                  ->comment('Total carbohydrates in grams per serving');

            $table->decimal('fat_g',     7, 2)->default(0)
                  ->comment('Total fat in grams per serving');

            $table->decimal('fiber_g',   7, 2)->default(0)->nullable();
            $table->decimal('sugar_g',   7, 2)->default(0)->nullable();
            $table->decimal('sodium_mg', 8, 2)->default(0)->nullable();

            // ── Serving info ───────────────────────────────────────────────
            $table->string('serving_size', 100)->nullable()
                  ->comment('e.g. "1 cup", "200g", "1 piece"');

            $table->unsignedSmallInteger('servings')->default(1);

            // ── Classification ─────────────────────────────────────────────
            $table->enum('meal_time', ['Breakfast', 'Lunch', 'Dinner', 'Snack', 'Any'])
                  ->default('Any');

            $table->string('cuisine_type', 100)->nullable()
                  ->comment('Malay / Chinese / Indian / Western / International');

            $table->text('dish_types')->nullable()
                  ->comment('JSON array from Spoonacular: ["main course","soup",...]');

            $table->text('diets')->nullable()
                  ->comment('JSON array: ["vegetarian","gluten free",...]');

            $table->text('ingredients')->nullable()
                  ->comment('Comma-separated ingredient list — used for allergy filtering');

            // ── DCR import context ─────────────────────────────────────────
            $table->unsignedSmallInteger('calorie_range_min')->nullable()
                  ->comment('Lower bound of DCR window used during this API fetch');

            $table->unsignedSmallInteger('calorie_range_max')->nullable()
                  ->comment('Upper bound of DCR window used during this API fetch');

            // ── Admin workflow ─────────────────────────────────────────────
            $table->enum('source', ['spoonacular', 'manual', 'ai_logger'])
                  ->default('spoonacular');

            $table->boolean('is_verified')->default(false)
                  ->comment('Admin must verify before item appears in recommendations');

            $table->boolean('is_active')->default(true)
                  ->comment('Soft-disable: false = hidden from recommendations but kept for history');

            $table->unsignedBigInteger('verified_by')->nullable()
                  ->comment('FK to users.id of the admin who approved this item');

            $table->timestamp('verified_at')->nullable();

            // ── Sync audit ─────────────────────────────────────────────────
            $table->timestamp('last_synced_at')->nullable()
                  ->comment('When this item was last fetched/refreshed from Spoonacular');

            $table->unsignedSmallInteger('sync_count')->default(0)
                  ->comment('How many times this item has been re-synced');

            $table->timestamps();   // created_at, updated_at

            // ── Indexes ────────────────────────────────────────────────────
            $table->index('meal_time',    'idx_food_meal_time');
            $table->index('calories',     'idx_food_calories');
            $table->index('cuisine_type', 'idx_food_cuisine');
            $table->index('is_verified',  'idx_food_verified');
            $table->index('is_active',    'idx_food_active');

            // Composite: the most common recommendation query
            $table->index(['meal_time', 'calories', 'is_verified', 'is_active'],
                          'idx_food_recommend_lookup');

            $table->foreign('verified_by')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_items');
    }
};