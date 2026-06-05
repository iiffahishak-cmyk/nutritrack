<?php

// ============================================================
//  app/Models/MealRating.php
// ============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MealRating extends Model
{
    protected $fillable = [
        'user_id',
        'meal_id',
        'rating',   // 1–5
        'review',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    // ── Relationships ──────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class, 'meal_id', 'meal_id');
    }

    // ── Scopes ────────────────────────────────────────────────────────────

    /** Only return ratings the user liked (≥ 4 stars) */
    public function scopeLiked($query)
    {
        return $query->where('rating', '>=', 4);
    }

    /** Count how many ratings a user has submitted */
    public static function countForUser(int $userId): int
    {
        return static::where('user_id', $userId)->count();
    }
}