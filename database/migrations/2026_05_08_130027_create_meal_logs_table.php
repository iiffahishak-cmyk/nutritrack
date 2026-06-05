<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    // We change the table name to 'meal_logs' because that's what your index.blade.php is looking for!
    Schema::create('meal_logs', function (Blueprint $table) {
        $table->id();
        
        // Links to users table
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        // FIXED: Links to 'meal_id' inside the 'meals' table
        $table->unsignedBigInteger('meal_id');
        $table->foreign('meal_id')
              ->references('meal_id') 
              ->on('meals')
              ->onDelete('cascade');

        $table->string('meal_time'); 
        $table->date('date');
        $table->string('meal_name');
        $table->integer('calories')->default(0);
        $table->float('protein_g')->default(0);
        $table->float('carbs_g')->default(0);
        $table->float('fat_g')->default(0);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('meal_logs');
}
};
