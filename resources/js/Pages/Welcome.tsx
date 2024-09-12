'use client'

import { useState } from 'react'
import { Dumbbell, Clock, Target, Star } from 'lucide-react'
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
    focusMuscles: MuscleGroup[],
    workoutDays: string[],
    duration: number
) => {
    const workouts: Record<string, string[]> = {}

    workoutDays.forEach((day) => {
        const dayWorkout: string[] = []
        const exercisesPerDay = Math.floor(duration / 15) // Assuming each exercise takes about 15 minutes

        for (let i = 0; i < exercisesPerDay; i++) {
            let musclePool = [
                ...selectedMuscles,
                ...focusMuscles,
                ...focusMuscles,
            ] // Add focus muscles twice for higher probability
            const selectedMuscle =
                musclePool[Math.floor(Math.random() * musclePool.length)]
            const exercise = `Exercise for ${selectedMuscle} (${
                focusMuscles.includes(selectedMuscle) ? 'Focus' : 'Regular'
            })`
            dayWorkout.push(exercise)
        }

        workouts[day] = dayWorkout
    })

    return workouts
}

export default function WorkoutGenerator() {
    const [selectedMuscles, setSelectedMuscles] = useState<MuscleGroup[]>([])
    const [focusMuscles, setFocusMuscles] = useState<MuscleGroup[]>([])
    const [selectedDays, setSelectedDays] = useState<string[]>([])
    const [duration, setDuration] = useState<number>(60)
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

    const handleToggleFocusMuscle = (muscle: MuscleGroup) => {
        setFocusMuscles((prev) =>
            prev.includes(muscle)
                ? prev.filter((m) => m !== muscle)
                : [...prev, muscle]
        )
    }
    console.log(focusMuscles)

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
            const generatedWorkout = generateWorkout(
                selectedMuscles,
                focusMuscles,
                selectedDays,
                duration
            )
            setWeeklyWorkout(generatedWorkout)
        }
    }

    return (
        <div className="container mx-auto p-4 max-w-md">
            <Card>
                <CardHeader>
                    <CardTitle className="text-2xl font-bold flex items-center gap-2">
                        <Dumbbell className="w-6 h-6 flex-shrink-0" />
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
                            <p className="text-sm text-gray-600 mb-4">
                                Check the boxes to select muscle groups. Click
                                the star icon next to a muscle group to set it
                                as a focus area. Focus areas will receive extra
                                attention in your workout plan.
                            </p>
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
                                            htmlFor={`muscle-${group.id}`}
                                            className="flex items-center gap-2"
                                        >
                                            {group.label}
                                        </Label>
                                        <button
                                            className={`w-6 h-6 flex items-center justify-center rounded border shadow p-0 ${
                                                focusMuscles.includes(group.id)
                                                    ? 'bg-yellow-400 text-primary-foreground'
                                                    : ''
                                            }`}
                                            onClick={() =>
                                                handleToggleFocusMuscle(
                                                    group.id
                                                )
                                            }
                                        >
                                            <Star className="w-4 h-4" />
                                            <span className="sr-only">
                                                Focus on {group.label}
                                            </span>
                                        </button>
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
                                        <Label htmlFor={`day-${day}`}>
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
                                max={120}
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
                        {focusMuscles.length > 0 && (
                            <div className="mt-4 p-4 bg-primary/10 rounded-md">
                                <h3 className="text-lg font-semibold mb-2 flex items-center gap-2">
                                    <Target className="w-5 h-5" />
                                    Focus Areas:
                                </h3>
                                <p className="text-sm">
                                    You've chosen to focus on:
                                    <span className="font-medium">
                                        {' '}
                                        {focusMuscles
                                            .map(
                                                (m) =>
                                                    muscleGroups.find(
                                                        (g) => g.id === m
                                                    )?.label
                                            )
                                            .join(', ')}
                                    </span>
                                </p>
                            </div>
                        )}
                        {Object.keys(weeklyWorkout).length > 0 && (
                            <div className="mt-4">
                                <h3 className="text-lg font-semibold mb-2">
                                    Your Weekly Workout Plan:
                                </h3>
                                {Object.entries(weeklyWorkout).map(
                                    ([day, exercises]) => (
                                        <div key={day} className="mb-4">
                                            <h4 className="font-semibold">
                                                {day}
                                            </h4>
                                            <ul className="list-disc pl-5 space-y-1">
                                                {exercises.map(
                                                    (exercise, index) => (
                                                        <li key={index}>
                                                            {exercise}
                                                        </li>
                                                    )
                                                )}
                                            </ul>
                                        </div>
                                    )
                                )}
                            </div>
                        )}
                    </div>
                </CardContent>
            </Card>
        </div>
    )
}
