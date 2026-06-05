<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id('profile_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('age');
            $table->enum('gender', ['male', 'female']);       // fixed: was plain string
            $table->decimal('weight_kg', 5, 2);              // fixed: was 'weight'
            $table->decimal('height_cm', 5, 2);              // fixed: was 'height'
            $table->enum('activity_level', [                  // fixed: was plain string
                'sedentary',
                'lightly_active',
                'moderately_active',
                'very_active',
                'extra_active'
            ]);
            $table->enum('goal', [                            // added: needed for DCR calc
                'lose_weight',
                'maintain',
                'gain_weight'
            ]);
            $table->decimal('bmr', 8, 2)->nullable();
            $table->decimal('tdee_value', 8, 2)->nullable();  // fixed: was 'tdee'
            $table->decimal('dcr_value', 8, 2)->nullable();   // added: Daily Calorie Req
            $table->string('allergies')->nullable();
            $table->string('preferred_cuisine')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};