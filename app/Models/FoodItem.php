<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class FoodItem extends Model
{
    protected $fillable = [
        'spoonacular_id',
        'meal_name',
        'description',
        'image_url',
        'calories',
        'protein_g',
        'carbs_g',
        'fat_g',
        'fiber_g',
        'sugar_g',
        'sodium_mg',
        'serving_size',
        'servings',
        'meal_time',
        'cuisine_type',
        'dish_types',
        'diets',
        'ingredients',
        'calorie_range_min',
        'calorie_range_max',
        'source',
        'is_verified',
        'is_active',
        'verified_by',
        'verified_at',
        'last_synced_at',
        'sync_count',
    ];

    protected $casts = [
        'dish_types' => 'array',
        'diets' => 'array',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'verified_at' => 'datetime',
        'last_synced_at' => 'datetime',
        'calories' => 'integer',
        'protein_g' => 'float',
        'carbs_g' => 'float',
        'fat_g' => 'float',
        'fiber_g' => 'float',
        'sugar_g' => 'float',
        'sodium_mg' => 'float',
    ];

    public function scopePendingVerification(Builder $query): Builder
    {
        return $query->where('is_verified', false)
            ->where('is_active', true);
    }

    public function scopeVerifiedActive(Builder $query): Builder
    {
        return $query->where('is_verified', true)
            ->where('is_active', true);
    }
}