<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meal_logs', function (Blueprint $table) {
            $table->dropForeign(['meal_id']);
            $table->unsignedBigInteger('meal_id')->nullable()->change();

            $table->foreign('meal_id')
                ->references('meal_id')
                ->on('meals')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('meal_logs', function (Blueprint $table) {
            $table->dropForeign(['meal_id']);
            $table->unsignedBigInteger('meal_id')->nullable(false)->change();

            $table->foreign('meal_id')
                ->references('meal_id')
                ->on('meals')
                ->cascadeOnDelete();
        });
    }
};