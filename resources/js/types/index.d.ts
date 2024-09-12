export interface User {
    id: number
    name: string
    email: string
    email_verified_at?: string
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    auth: {
        user: User
    }
}

export interface MuscleGroup {
    id: string
    name: string
    created_at: string
    updated_at: string
}

export interface Exercise {
    id: string
    muscle_group_id: number
    trained_muscles: string
    name: string
    twitter_url: string
    created_at: string
    updated_at: string
    muscle_group: MuscleGroup
}

export interface WorkoutPlanSet {
    id: string
    workout_plan_id: number
    exercise_id: number
    reps: number
    sets: number
    day: string
    created_at: string
    updated_at: string
    exercise: Exercise
}

export interface DayWorkout {
    exercises: WorkoutPlanSet[]
    focus_muscle_groups: string[]
}

export interface WorkoutPlanGroupedByDay {
    [day: string]: DayWorkout
}
