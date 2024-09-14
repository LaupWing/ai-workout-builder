import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card'
import { Exercise, PageProps, WorkoutPlanSet } from '@/types'
import { Dumbbell, Clock, ExternalLink, Link } from 'lucide-react'

// type Exercise = {
//     name: string
//     muscleGroup: string
//     videoLink: string
// }

type WorkoutDay = {
    mainFocus: string
    exercises: Exercise[]
}

type WorkoutDayProps = {
    exercises: WorkoutPlanSet[]
    focus_muscle_groups: string[]
}

interface WorkoutPlanProps {
    monday?: WorkoutDayProps | string
    tuesday?: WorkoutDayProps | string
    wednesday?: WorkoutDayProps | string
    thursday?: WorkoutDayProps | string
    friday?: WorkoutDayProps | string
    saturday?: WorkoutDayProps | string
    sunday?: WorkoutDayProps | string
}

const weeks: WorkoutPlanProps = {
    monday: {
        exercises: [
            {
                id: '18',
                workout_plan_id: 3,
                exercise_id: 1,
                reps: 15,
                sets: 6,
                day: 'monday',
                created_at: '2024-09-14T12:38:49.000000Z',
                updated_at: '2024-09-14T12:38:49.000000Z',
                exercise: {
                    id: '1',
                    muscle_group_id: 1,
                    trained_muscles: 'Chest, Shoulders, Triceps',
                    name: 'Bench Press',
                    twitter_url:
                        'https://x.com/LaupWing1994/status/1791440038615535782',
                    created_at: '2024-09-13T14:56:33.000000Z',
                    updated_at: '2024-09-13T14:56:33.000000Z',
                    muscle_group: {
                        id: '1',
                        name: 'chest',
                        created_at: '2024-09-13T14:56:33.000000Z',
                        updated_at: '2024-09-13T14:56:33.000000Z',
                    },
                },
            },
            {
                id: '19',
                workout_plan_id: 3,
                exercise_id: 16,
                reps: 12,
                sets: 5,
                day: 'monday',
                created_at: '2024-09-14T12:38:49.000000Z',
                updated_at: '2024-09-14T12:38:49.000000Z',
                exercise: {
                    id: '16',
                    muscle_group_id: 4,
                    trained_muscles: 'Biceps',
                    name: 'Dumbbell Bicep Curl',
                    twitter_url:
                        'https://x.com/LaupWing1994/status/1791442306895122876',
                    created_at: '2024-09-13T14:56:34.000000Z',
                    updated_at: '2024-09-13T14:56:34.000000Z',
                    muscle_group: {
                        id: '4',
                        name: 'arms',
                        created_at: '2024-09-13T14:56:33.000000Z',
                        updated_at: '2024-09-13T14:56:33.000000Z',
                    },
                },
            },
            {
                id: '20',
                workout_plan_id: 3,
                exercise_id: 20,
                reps: 30,
                sets: 3,
                day: 'monday',
                created_at: '2024-09-14T12:38:49.000000Z',
                updated_at: '2024-09-14T12:38:49.000000Z',
                exercise: {
                    id: '20',
                    muscle_group_id: 6,
                    trained_muscles: 'Abs, Hip Flexors',
                    name: 'Hanging Leg Raise',
                    twitter_url:
                        'https://x.com/LaupWing1994/status/1791442324922237037',
                    created_at: '2024-09-13T14:56:34.000000Z',
                    updated_at: '2024-09-13T14:56:34.000000Z',
                    muscle_group: {
                        id: '6',
                        name: 'core',
                        created_at: '2024-09-13T14:56:33.000000Z',
                        updated_at: '2024-09-13T14:56:33.000000Z',
                    },
                },
            },
        ],
        focus_muscle_groups: ['chest', 'arms', 'core'],
    },
    saturday: {
        exercises: [
            {
                id: '21',
                workout_plan_id: 3,
                exercise_id: 17,
                reps: 12,
                sets: 4,
                day: 'saturday',
                created_at: '2024-09-14T12:38:49.000000Z',
                updated_at: '2024-09-14T12:38:49.000000Z',
                exercise: {
                    id: '17',
                    muscle_group_id: 4,
                    trained_muscles: 'Biceps, Brachialis',
                    name: 'Dumbbell Hammer Curl',
                    twitter_url:
                        'https://x.com/LaupWing1994/status/1791442311261339708',
                    created_at: '2024-09-13T14:56:34.000000Z',
                    updated_at: '2024-09-13T14:56:34.000000Z',
                    muscle_group: {
                        id: '4',
                        name: 'arms',
                        created_at: '2024-09-13T14:56:33.000000Z',
                        updated_at: '2024-09-13T14:56:33.000000Z',
                    },
                },
            },
            {
                id: '22',
                workout_plan_id: 3,
                exercise_id: 17,
                reps: 12,
                sets: 4,
                day: 'saturday',
                created_at: '2024-09-14T12:38:49.000000Z',
                updated_at: '2024-09-14T12:38:49.000000Z',
                exercise: {
                    id: '17',
                    muscle_group_id: 4,
                    trained_muscles: 'Biceps, Brachialis',
                    name: 'Dumbbell Hammer Curl',
                    twitter_url:
                        'https://x.com/LaupWing1994/status/1791442311261339708',
                    created_at: '2024-09-13T14:56:34.000000Z',
                    updated_at: '2024-09-13T14:56:34.000000Z',
                    muscle_group: {
                        id: '4',
                        name: 'arms',
                        created_at: '2024-09-13T14:56:33.000000Z',
                        updated_at: '2024-09-13T14:56:33.000000Z',
                    },
                },
            },
        ],
        focus_muscle_groups: ['arms'],
    },
}

export default function WorkoutPlan(
    props: PageProps<{
        workoutPlan: any
        days: string[]
    }>
) {
    const _weeks: WorkoutPlanProps = {}

    props.days.forEach((day) => {
        console.log(day)
        if (Object.keys(weeks).includes(day)) {
            // @ts-ignore
            _weeks[day] = weeks[day]
        } else {
            // @ts-ignore
            _weeks[day] = 'Rest day'
        }
        // if (props.workoutPlan[day]) {
        //     // @ts-ignore
        //     _weeks[day] = props.workoutPlan[day]
        // } else {
        //     // @ts-ignore
        //     _weeks[day] = weeks[day]
        // }
    })
    console.log(_weeks)

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
                        {props.days.map((day) => (
                            <div
                                key={day}
                                className="border-t pt-4 first:border-t-0 first:pt-0"
                            >
                                <div className="flex justify-between items-center mb-2">
                                    <h3 className="text-lg capitalize font-semibold">
                                        {day}
                                    </h3>
                                    {/* @ts-ignore */}
                                    {typeof _weeks[day] !== 'string' && (
                                        <span className="text-sm font-medium px-2 py-1 bg-primary/10 text-primary rounded-full capitalize">
                                            {/* @ts-ignore */}
                                            {_weeks[
                                                day
                                            ].focus_muscle_groups.join(', ')}
                                        </span>
                                    )}
                                </div>
                                {/* @ts-ignore */}
                                {typeof _weeks[day] !== 'string' ? (
                                    <ul className="list-disc pl-5 space-y-2">
                                        {/* @ts-ignore */}
                                        {_weeks[day].exercises.map(
                                            (
                                                exercise: WorkoutPlanSet,
                                                index: number
                                            ) => (
                                                <li key={index}>
                                                    <div className="flex items-center justify-between">
                                                        <span className="font-medium">
                                                            {
                                                                exercise
                                                                    .exercise
                                                                    .name
                                                            }
                                                        </span>
                                                        <a
                                                            href={
                                                                exercise
                                                                    .exercise
                                                                    .twitter_url
                                                            }
                                                            target="_blank"
                                                        >
                                                            <ExternalLink className="w-4 h-4" />
                                                            <span className="sr-only">
                                                                Watch video
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <span className="text-sm text-gray-600">
                                                        Targets:{' '}
                                                        {
                                                            exercise.exercise
                                                                .trained_muscles
                                                        }
                                                    </span>
                                                </li>
                                            )
                                        )}
                                    </ul>
                                ) : (
                                    <p className="text-gray-500 italic">
                                        {/* @ts-ignore */}
                                        {_weeks[day]}
                                    </p>
                                )}
                            </div>
                        ))}
                    </div>
                </CardContent>
            </Card>
        </div>
    )
}
