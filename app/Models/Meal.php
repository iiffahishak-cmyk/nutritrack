<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $primaryKey = 'meal_id';

    protected $fillable = [
    'spoonacular_id',
    'meal_name',
    'description',
    'calories',
    'protein',
    'carbs',
    'fat',
    'meal_time',
    'cuisine_type',
    'ingredients',
    'image_url',
    'source',
];
public function getImageUrlAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        // Generate dynamic colored placeholder using the exact meal_name
        $color = substr(md5($this->meal_name), 0, 6);
        $nameEncoded = urlencode($this->meal_name);
        return "https://ui-avatars.com/api/?name={$nameEncoded}&background={$color}&color=fff&size=512";
    }
    public function recommendationItems()
    {
        return $this->hasMany(RecommendationItem::class, 'meal_id', 'meal_id');
    }
    public function ratings() {
    return $this->hasMany(MealRating::class, 'meal_id', 'meal_id');
}
}