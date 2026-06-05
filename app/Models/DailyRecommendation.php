<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyRecommendation extends Model
{
    protected $primaryKey = 'recommendation_id';

    protected $fillable = [
        'user_id',
        'for_date',                 // fixed: was 'recommendation_date'
        'total_calories_target',    // added
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(RecommendationItem::class, 'recommendation_id', 'recommendation_id');
    }
}