import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card'
import { Dumbbell, Clock } from 'lucide-react'

type Exercise = {
    name: string
    muscleGroup: string
}

type WorkoutDay = {
    mainFocus: string
    exercises: Exercise[]
}

export default function ExampleWorkoutPlan() {
    const exampleWorkout: Record<string, WorkoutDay | string> = {
        Monday: {
            mainFocus: 'Chest & Triceps',
            exercises: [
                { name: '3 x 10 Bench Press', muscleGroup: 'Chest' },
                {
                    name: '3 x 12 Incline Dumbbell Press',
                    muscleGroup: 'Upper Chest',
                },
                {
                    name: '3 x 15 Push-ups',
                    muscleGroup: 'Chest, Shoulders, Triceps',
                },
                { name: '3 x 12 Tricep Pushdowns', muscleGroup: 'Triceps' },
            ],
        },
        Tuesday: {
            mainFocus: 'Legs & Core',
            exercises: [
                {
                    name: '3 x 10 Squats',
                    muscleGroup: 'Quadriceps, Glutes, Hamstrings',
                },
                {
                    name: '3 x 12 Lunges',
                    muscleGroup: 'Quadriceps, Glutes, Hamstrings',
                },
                { name: '3 x 15 Leg Press', muscleGroup: 'Quadriceps, Glutes' },
                { name: '3 x 20 Crunches', muscleGroup: 'Core' },
            ],
        },
        Wednesday: 'Rest day',
        Thursday: {
            mainFocus: 'Back & Biceps',
            exercises: [
                { name: '3 x 10 Pull-ups', muscleGroup: 'Back, Biceps' },
                { name: '3 x 12 Bent-over Rows', muscleGroup: 'Back' },
                { name: '3 x 15 Lat Pulldowns', muscleGroup: 'Back, Biceps' },
                { name: '3 x 10 Bicep Curls', muscleGroup: 'Biceps' },
            ],
        },
        Friday: {
            mainFocus: 'Shoulders & Core',
            exercises: [
                { name: '3 x 10 Military Press', muscleGroup: 'Shoulders' },
                {
                    name: '3 x 12 Lateral Raises',
                    muscleGroup: 'Lateral Deltoids',
                },
                { name: '3 x 15 Front Raises', muscleGroup: 'Front Deltoids' },
                { name: '3 x 30s Plank', muscleGroup: 'Core' },
            ],
        },
        Saturday: {
            mainFocus: 'Legs & Core',
            exercises: [
                {
                    name: '3 x 12 Lunges',
                    muscleGroup: 'Quadriceps, Glutes, Hamstrings',
                },
                { name: '3 x 15 Leg Press', muscleGroup: 'Quadriceps, Glutes' },
                { name: '3 x 12 Calf Raises', muscleGroup: 'Calves' },
                {
                    name: '3 x 15 Russian Twists',
                    muscleGroup: 'Core, Obliques',
                },
            ],
        },
        Sunday: 'Rest day',
    }

    return (
        <div className="container mx-auto p-4 max-w-2xl">
            <Card>
                <CardHeader>
                    <CardTitle className="text-2xl font-bold flex items-center gap-2">
                        <Dumbbell className="w-6 h-6" />
                        Example Weekly Workout Plan
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <div className="space-y-6">
                        <div className="flex items-center gap-2 text-sm text-gray-600">
                            <Clock className="w-4 h-4" />
                            <span>
                                Workout Duration: 60 minutes per session
                            </span>
                        </div>
                        {Object.entries(exampleWorkout).map(
                            ([day, workout]) => (
                                <div
                                    key={day}
                                    className="border-t pt-4 first:border-t-0 first:pt-0"
                                >
                                    <div className="flex justify-between items-center mb-2">
                                        <h3 className="text-lg font-semibold">
                                            {day}
                                        </h3>
                                        {typeof workout !== 'string' && (
                                            <span className="text-sm font-medium px-2 py-1 bg-primary/10 text-primary rounded-full">
                                                {workout.mainFocus}
                                            </span>
                                        )}
                                    </div>
                                    {typeof workout !== 'string' ? (
                                        <ul className="list-disc pl-5 space-y-2">
                                            {workout.exercises.map(
                                                (exercise, index) => (
                                                    <li key={index}>
                                                        <span className="font-medium">
                                                            {exercise.name}
                                                        </span>
                                                        <br />
                                                        <span className="text-sm text-gray-600">
                                                            Targets:{' '}
                                                            {
                                                                exercise.muscleGroup
                                                            }
                                                        </span>
                                                    </li>
                                                )
                                            )}
                                        </ul>
                                    ) : (
                                        <p className="text-gray-500 italic">
                                            {workout}
                                        </p>
                                    )}
                                </div>
                            )
                        )}
                    </div>
                </CardContent>
            </Card>
        </div>
    )
}
