import { useState } from 'react'
import { Dumbbell, Clock } from 'lucide-react'
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/Components/ui/card'
import { Checkbox } from '@/Components/ui/checkbox'
import { Label } from '@/Components/ui/label'
import { Button } from '@/Components/ui/button'
import { Slider } from '@/Components/ui/slider'
import { PageProps } from '@/types'

type MuscleGroup = 'chest' | 'back' | 'legs' | 'arms' | 'shoulders' | 'core'

const muscleGroups: { id: MuscleGroup; label: string }[] = [
    { id: 'chest', label: 'Chest' },
    { id: 'back', label: 'Back' },
    { id: 'legs', label: 'Legs' },
    { id: 'arms', label: 'Arms' },
    { id: 'shoulders', label: 'Shoulders' },
    { id: 'core', label: 'Core' },
]

// Mock function to simulate AI workout generation
const generateWorkout = (
    selectedMuscles: MuscleGroup[],
    workoutDays: string[],
    duration: number
) => {
    const workouts: Record<MuscleGroup, string[]> = {
        chest: [
            '3 x 10 Bench Press',
            '3 x 12 Incline Dumbbell Press',
            '3 x 15 Push-ups',
            '3 x 12 Cable Flyes',
        ],
        back: [
            '3 x 10 Pull-ups',
            '3 x 12 Bent-over Rows',
            '3 x 15 Lat Pulldowns',
            '3 x 12 Face Pulls',
        ],
        legs: [
            '3 x 10 Squats',
            '3 x 12 Lunges',
            '3 x 15 Leg Press',
            '3 x 12 Calf Raises',
        ],
        arms: [
            '3 x 10 Bicep Curls',
            '3 x 12 Tricep Pushdowns',
            '3 x 15 Hammer Curls',
            '3 x 12 Skull Crushers',
        ],
        shoulders: [
            '3 x 10 Military Press',
            '3 x 12 Lateral Raises',
            '3 x 15 Front Raises',
            '3 x 12 Reverse Flyes',
        ],
        core: [
            '3 x 20 Crunches',
            '3 x 30s Plank',
            '3 x 15 Russian Twists',
            '3 x 20 Leg Raises',
        ],
    }

    let weeklyWorkout: Record<string, string[]> = {}
    let muscleIndex = 0

    workoutDays.forEach((day) => {
        const dayWorkout: string[] = []
        const exercisesPerDay = Math.floor(duration / 15) // Assuming each exercise takes about 15 minutes
        for (let j = 0; j < exercisesPerDay; j++) {
            const muscle = selectedMuscles[muscleIndex % selectedMuscles.length]
            const exercise = workouts[muscle][j % workouts[muscle].length]
            dayWorkout.push(exercise)
            muscleIndex++
        }
        weeklyWorkout[day] = dayWorkout
    })

    return weeklyWorkout
}

export default function WorkoutGenerator({
    daysOfWeek,
    muscleGroups,
}: PageProps<{
    daysOfWeek: string[]
    muscleGroups: { id: string; name: MuscleGroup }[]
}>) {
    const [selectedMuscles, setSelectedMuscles] = useState<string[]>([])
    const [selectedDays, setSelectedDays] = useState<string[]>([])
    const [duration, setDuration] = useState<number>(60)
    const [weeklyWorkout, setWeeklyWorkout] = useState<
        Record<string, string[]>
    >({})

    const handleToggleMuscle = (muscle: string) => {
        setSelectedMuscles((prev) =>
            prev.includes(muscle)
                ? prev.filter((m) => m !== muscle)
                : [...prev, muscle]
        )
    }

    const handleToggleDay = (day: string) => {
        setSelectedDays((prev) =>
            prev.includes(day) ? prev.filter((d) => d !== day) : [...prev, day]
        )
    }

    const handleDurationChange = (value: number[]) => {
        setDuration(value[0])
    }

    const handleGenerateWorkout = () => {
        if (selectedMuscles.length > 0 && selectedDays.length > 0) {
            // const generatedWorkout = generateWorkout(
            //     selectedMuscles,
            //     selectedDays,
            //     duration
            // )
            // setWeeklyWorkout(generatedWorkout)
        }
    }

    return (
        <div className="container mx-auto p-4 max-w-md">
            <Card>
                <CardHeader>
                    <CardTitle className="text-2xl font-bold flex items-center gap-2">
                        <Dumbbell className="w-6 h-6" />
                        AI Weekly Workout Generator
                    </CardTitle>
                    <CardDescription>
                        Customize your weekly workout plan
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div className="space-y-6">
                        <div>
                            <h3 className="text-lg font-semibold mb-2">
                                Select Muscle Groups:
                            </h3>
                            <div className="space-y-2">
                                {muscleGroups.map((group) => (
                                    <div
                                        key={group.id}
                                        className="flex items-center space-x-2"
                                    >
                                        <Checkbox
                                            id={`muscle-${group.id}`}
                                            checked={selectedMuscles.includes(
                                                group.id
                                            )}
                                            onCheckedChange={() =>
                                                handleToggleMuscle(group.id)
                                            }
                                        />
                                        <Label
                                            className="capitalize"
                                            htmlFor={`muscle-${group.id}`}
                                        >
                                            {group.name}
                                        </Label>
                                    </div>
                                ))}
                            </div>
                        </div>
                        <div>
                            <h3 className="text-lg font-semibold mb-2">
                                Select Workout Days:
                            </h3>
                            <div className="space-y-2">
                                {daysOfWeek.map((day) => (
                                    <div
                                        key={day}
                                        className="flex items-center space-x-2"
                                    >
                                        <Checkbox
                                            id={`day-${day}`}
                                            checked={selectedDays.includes(day)}
                                            onCheckedChange={() =>
                                                handleToggleDay(day)
                                            }
                                        />
                                        <Label
                                            className="capitalize"
                                            htmlFor={`day-${day}`}
                                        >
                                            {day}
                                        </Label>
                                    </div>
                                ))}
                            </div>
                        </div>
                        <div>
                            <h3 className="text-lg font-semibold mb-2 flex items-center gap-2">
                                <Clock className="w-5 h-5" />
                                Workout Duration:
                            </h3>
                            <Slider
                                min={30}
                                max={180}
                                step={15}
                                value={[duration]}
                                onValueChange={handleDurationChange}
                                className="mb-2"
                            />
                            <p className="text-sm text-gray-600">
                                {duration} minutes per session
                            </p>
                        </div>
                        <Button
                            onClick={handleGenerateWorkout}
                            className="w-full"
                            disabled={
                                selectedMuscles.length === 0 ||
                                selectedDays.length === 0
                            }
                        >
                            Generate Weekly Workout
                        </Button>
                        {Object.keys(weeklyWorkout).length > 0 && (
                            <div className="mt-4">
                                <h3 className="text-lg font-semibold mb-2">
                                    Your Weekly Workout Plan:
                                </h3>
                                {daysOfWeek.map((day) => (
                                    <div key={day} className="mb-4">
                                        <h4 className="font-semibold">{day}</h4>
                                        {weeklyWorkout[day] ? (
                                            <ul className="list-disc pl-5 space-y-1">
                                                {weeklyWorkout[day].map(
                                                    (exercise, index) => (
                                                        <li key={index}>
                                                            {exercise}
                                                        </li>
                                                    )
                                                )}
                                            </ul>
                                        ) : (
                                            <p className="text-gray-500 italic">
                                                Rest day
                                            </p>
                                        )}
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                </CardContent>
            </Card>
        </div>
    )
}
