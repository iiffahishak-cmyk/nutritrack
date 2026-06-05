<?php
// ============================================================
//  app/Models/MealLog.php
// ============================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MealLog extends Model
{protected $fillable = [
    'user_id',
    'meal_id',
    'meal_time',
    'date',
    'meal_name',
    'calories',
    'protein_g',
    'carbs_g',
    'fat_g',
    'source',
];

    protected $casts = [
        'date'      => 'date',
        'calories'  => 'integer',
        'protein_g' => 'float',
        'carbs_g'   => 'float',
        'fat_g'     => 'float',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function meal(): BelongsTo { return $this->belongsTo(Meal::class, 'meal_id', 'meal_id'); }
}