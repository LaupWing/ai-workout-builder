<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkoutPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'duration_minutes_per_session',
    ];

    public function workoutPlanSets(): HasMany
    {
        return $this->hasMany(WorkoutPlanSets::class);
    }
}
