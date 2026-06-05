<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id('meal_id');
            $table->string('meal_name');                      // fixed: was 'name'
            $table->text('description')->nullable();          // added
            $table->decimal('calories', 8, 2);               // fixed: was integer
            $table->decimal('protein', 6, 2);
            $table->decimal('carbs', 6, 2);
            $table->decimal('fat', 6, 2);
            $table->enum('meal_time', [                       // fixed: was 'time_to_consume'
                'Breakfast',
                'Lunch',
                'Dinner',
                'Snack'
            ]);
            $table->string('cuisine_type')->nullable();
            $table->text('ingredients')->nullable();          // for allergy checking
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};