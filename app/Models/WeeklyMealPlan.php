<?php

// ============================================================
//  app/Models/WeeklyMealPlan.php
//
//  ROOT CAUSE OF EMPTY DATA:
//  belongsTo(Meal::class) with NO keys specified means Laravel
//  looks for meals WHERE id = weekly_meal_plans.meal_id
//  BUT your meals table uses meal_id as the primary key, NOT id.
//  Fix: specify both the foreign key AND the owner key.
// ============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class WeeklyMealPlan extends Model
{
    protected $fillable = [
        'user_id',
        'week_start_date',
        'day_of_week',
        'meal_time',
        'meal_id',
        'calories_target',
    ];

    protected $casts = [
        'week_start_date' => 'date',
        'day_of_week'     => 'integer',
        'calories_target' => 'integer',
    ];

    // ── Relationships ─────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * FIXED: Must specify both keys explicitly.
     *
     * belongsTo(Model, foreignKey, ownerKey)
     *   foreignKey = column on THIS table  = 'meal_id'
     *   ownerKey   = primary key on meals  = 'meal_id'  ← this was missing!
     *
     * Without ownerKey, Laravel defaults to 'id' on the meals table,
     * which doesn't exist — so $plan->meal always returns null.
     */
    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class, 'meal_id', 'meal_id');
    }

    // ── Static helpers ────────────────────────────────────────────────────

    /**
     * Returns the Monday date string for any given Carbon date.
     * Used by controller to find/save the correct week.
     */
    public static function weekStart(Carbon $date): string
    {
        return $date->copy()->startOfWeek(Carbon::MONDAY)->toDateString();
    }
}