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

    // Method to group workoutPlanSets by day
    public function groupByDay()
    {
        // Load the related exercise and muscle group for each workout plan set
        $sets = $this->workoutPlanSets()
            ->with('exercise.muscleGroup') // Eager load related data
            ->get();

        // Group the sets by 'day' field
        return $sets->groupBy('day');
    }


    // Method to group workoutPlanSets by day and include focus muscle groups
    public function groupByDayWithFocusMuscles()
    {
        // Load the related exercise and muscle group for each workout plan set
        $sets = $this->workoutPlanSets()
            ->with('exercise.muscleGroup') // Eager load related data
            ->get();

        // Group the sets by 'day' field
        $grouped = $sets->groupBy('day');

        // Process each group (day) to calculate the focus muscle groups
        $groupedWithFocusMuscles = $grouped->map(function ($daySets, $day) {
            // Extract the unique muscle groups for this day
            $muscleGroups = $daySets
                ->pluck('exercise.muscleGroup.name') // Get muscle group names
                ->unique() // Ensure uniqueness
                ->values(); // Re-index the array

            return [
                'exercises' => $daySets, // All the sets for the day
                'focus_muscle_groups' => $muscleGroups, // The focus muscle groups for the day
            ];
        });

        return $groupedWithFocusMuscles;
    }
}
