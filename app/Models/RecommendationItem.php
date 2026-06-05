<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecommendationItem extends Model
{
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'recommendation_id',
        'meal_id',
        'suggested_time',
    ];

    public function recommendation()
    {
        return $this->belongsTo(DailyRecommendation::class, 'recommendation_id', 'recommendation_id');
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class, 'meal_id', 'meal_id');
    }
}