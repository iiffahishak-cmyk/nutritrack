<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meals', function (Blueprint $table) {
            if (! Schema::hasColumn('meals', 'spoonacular_id')) {
                $table->unsignedBigInteger('spoonacular_id')->nullable()->unique()->after('meal_id');
            }

            if (! Schema::hasColumn('meals', 'source')) {
                $table->string('source')->default('manual')->after('image_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('meals', function (Blueprint $table) {
            if (Schema::hasColumn('meals', 'spoonacular_id')) {
                $table->dropUnique(['spoonacular_id']);
                $table->dropColumn('spoonacular_id');
            }

            if (Schema::hasColumn('meals', 'source')) {
                $table->dropColumn('source');
            }
        });
    }
};