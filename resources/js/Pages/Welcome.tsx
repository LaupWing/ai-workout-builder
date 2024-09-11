'use client'

import { useState } from 'react'
import { Dumbbell } from 'lucide-react'
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/Components/ui/card'
import Checkbox from '@/Components/Checkbox'
import { Label } from '@/Components/ui/label'
import { Button } from '@/Components/ui/button'

type MuscleGroup = 'chest' | 'back' | 'legs' | 'arms' | 'shoulders' | 'core'

const muscleGroups: { id: MuscleGroup; label: string }[] = [
    { id: 'chest', label: 'Chest' },
    { id: 'back', label: 'Back' },
    { id: 'legs', label: 'Legs' },
    { id: 'arms', label: 'Arms' },
    { id: 'shoulders', label: 'Shoulders' },
    { id: 'core', label: 'Core' },
]

const daysOfWeek = [
    'Monday',
    'Tuesday',
    'Wednesday',
    'Thursday',
    'Friday',
    'Saturday',
    'Sunday',
]

// Mock function to simulate AI workout generation
const generateWorkout = (
    selectedMuscles: MuscleGroup[],
    workoutDays: string[]
) => {
    const workouts: Record<MuscleGroup, string[]> = {
        chest: [
            '3 x 10 Bench Press',
            '3 x 12 Incline Dumbbell Press',
            '3 x 15 Push-ups',
        ],
        back: [
            '3 x 10 Pull-ups',
            '3 x 12 Bent-over Rows',
            '3 x 15 Lat Pulldowns',
        ],
        legs: ['3 x 10 Squats', '3 x 12 Lunges', '3 x 15 Leg Press'],
        arms: [
            '3 x 10 Bicep Curls',
            '3 x 12 Tricep Pushdowns',
            '3 x 15 Hammer Curls',
        ],
        shoulders: [
            '3 x 10 Military Press',
            '3 x 12 Lateral Raises',
            '3 x 15 Front Raises',
        ],
        core: ['3 x 20 Crunches', '3 x 30s Plank', '3 x 15 Russian Twists'],
    }

    let weeklyWorkout: Record<string, string[]> = {}
    let muscleIndex = 0

    workoutDays.forEach((day) => {
        const dayWorkout: string[] = []
        for (let j = 0; j < 3; j++) {
            const muscle = selectedMuscles[muscleIndex % selectedMuscles.length]
            const exercise =
                workouts[muscle][
                    Math.floor(Math.random() * workouts[muscle].length)
                ]
            dayWorkout.push(exercise)
            muscleIndex++
        }
        weeklyWorkout[day] = dayWorkout
    })

    return weeklyWorkout
}

export default function WorkoutGenerator() {
    const [selectedMuscles, setSelectedMuscles] = useState<MuscleGroup[]>([])
    const [selectedDays, setSelectedDays] = useState<string[]>([])
    const [weeklyWorkout, setWeeklyWorkout] = useState<
        Record<string, string[]>
    >({})

    const handleToggleMuscle = (muscle: MuscleGroup) => {
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

    const handleGenerateWorkout = () => {
        if (selectedMuscles.length > 0 && selectedDays.length > 0) {
            const generatedWorkout = generateWorkout(
                selectedMuscles,
                selectedDays
            )
            setWeeklyWorkout(generatedWorkout)
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
                        Select muscle groups and workout days for a personalized
                        weekly plan
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
                                            onCheckedChange={() => {}}
                                        />
                                        <Label htmlFor={`muscle-${group.id}`}>
                                            {group.label}
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
                                            // onCheckedChange={() =>
                                            //     handleToggleDay(day)
                                            // }
                                        />
                                        <Label htmlFor={`day-${day}`}>
                                            {day}
                                        </Label>
                                    </div>
                                ))}
                            </div>
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
