<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $primaryKey = 'profile_id';

    protected $fillable = [
        'user_id',
        'age',
        'gender',
        'weight_kg',            // fixed: was 'weight'
        'height_cm',            // fixed: was 'height'
        'activity_level',
        'goal',                 // added
        'bmr',
        'tdee_value',           // fixed: was 'tdee'
        'dcr_value',            // added
        'allergies',
        'preferred_cuisine',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}