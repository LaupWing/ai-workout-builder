import { Button } from '@/Components/ui/button'
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card'
import { toast } from '@/hooks/use-toast'
import { PageProps, WorkoutPlanSet, WorkoutPlanType } from '@/types'
import { router } from '@inertiajs/react'
import { Dumbbell, Clock, ExternalLink, Link, Mail } from 'lucide-react'
import { useState } from 'react'

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

export default function WorkoutPlan(
    props: PageProps<{
        groupedByDayWithFocusMuscles: any
        days: string[]
        workoutPlan: WorkoutPlanType
    }>
) {
    const _weeks: WorkoutPlanProps = {}
    const [sended, setSended] = useState(false)
    props.days.forEach((day) => {
        if (Object.keys(props.groupedByDayWithFocusMuscles).includes(day)) {
            // @ts-ignore
            _weeks[day] = props.groupedByDayWithFocusMuscles[day]
        } else {
            // @ts-ignore
            _weeks[day] = 'Rest day'
        }
    })

    const sendProgram = async () => {
        setSended(true)
        router.get(
            `/send-workout-plan/${props.workoutPlan.id}`,
            {},
            {
                preserveState: true,
                onStart: () => {
                    console.log('sending')
                },
                onSuccess: () => {
                    toast({
                        title: 'Workout Plan Sent',
                        description: 'Check your email for the workout plan',
                    })
                },
            }
        )
    }

    return (
        <div className="container mx-auto p-4 max-w-2xl">
            <Card>
                <CardHeader>
                    <CardTitle className="text-2xl font-bold flex items-center gap-2">
                        <Dumbbell className="w-6 h-6 flex-shrink-0" />
                        Example Weekly Workout Plan
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <div className="space-y-6">
                        <div className="flex items-center gap-2 text-sm text-gray-600">
                            <Clock className="w-4 h-4" />
                            <span>
                                Workout Duration:{' '}
                                {props.workoutPlan.duration_minutes_per_session}{' '}
                                minutes per session
                            </span>
                        </div>
                        <Button
                            disabled={sended}
                            className="flex gap-1 uppercase text-sm items-center"
                            onClick={sendProgram}
                        >
                            Send to my email <Mail size={20} />
                        </Button>
                        {props.days.map((day) => (
                            <>
                                {/* @ts-ignore */}
                                {typeof _weeks[day] ? (
                                    <div
                                        key={day}
                                        className="border-t pt-4 first:border-t-0 first:pt-0"
                                    >
                                        <div className="flex justify-between items-center mb-2">
                                            <h3 className="text-lg capitalize font-semibold">
                                                {day}
                                            </h3>
                                            {/* @ts-ignore */}
                                            {typeof _weeks[day] !==
                                                'string' && (
                                                <span className="text-sm font-medium px-2 py-1 bg-primary/10 text-primary rounded-full capitalize">
                                                    {/* @ts-ignore */}
                                                    {_weeks[
                                                        day
                                                    ].focus_muscle_groups.join(
                                                        ', '
                                                    )}
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
                                                                        exercise.sets
                                                                    }{' '}
                                                                    x{' '}
                                                                    {
                                                                        exercise.reps
                                                                    }{' '}
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
                                                                        Watch
                                                                        video
                                                                    </span>
                                                                </a>
                                                            </div>
                                                            <span className="text-sm text-gray-600">
                                                                Targets:{' '}
                                                                {
                                                                    exercise
                                                                        .exercise
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
                                ) : null}
                            </>
                        ))}
                    </div>
                </CardContent>
            </Card>
        </div>
    )
}
