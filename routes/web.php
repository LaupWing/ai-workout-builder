<?php

use App\Http\Requests\GenerateWorkoutRequest;
use App\Models\Exercise;
use App\Models\MuscleGroup;
use App\Models\WorkoutPlan;
use App\Models\WorkoutPlanSets;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

$workoutPlan = [
    'Monday' => [
        'mainFocus' => 'Chest & Triceps',
        'exercises' => [
            [
                'exercise_id' => 1,  // Bench Press
                'sets' => 3,
                'reps' => 10,
            ],
            [
                'exercise_id' => 2,  // Incline Dumbbell Press
                'sets' => 3,
                'reps' => 12,
            ],
            [
                'exercise_id' => 18, // Dumbbell Skull Crusher
                'sets' => 3,
                'reps' => 15,
            ],
            [
                'exercise_id' => 19, // Cable Rope Tricep Extension
                'sets' => 3,
                'reps' => 12,
            ],
        ],
    ],
    'Tuesday' => [
        'mainFocus' => 'Legs & Core',
        'exercises' => [
            [
                'exercise_id' => 11, // Barbell Squat
                'sets' => 3,
                'reps' => 10,
            ],
            [
                'exercise_id' => 14, // Lunges
                'sets' => 3,
                'reps' => 12,
            ],
            [
                'exercise_id' => 12, // Leg Extension
                'sets' => 3,
                'reps' => 15,
            ],
            [
                'exercise_id' => 21, // Cable Crunch
                'sets' => 3,
                'reps' => 20,
            ],
        ],
    ],
    'Wednesday' => 'Rest day',
    'Thursday' => [
        'mainFocus' => 'Back & Biceps',
        'exercises' => [
            [
                'exercise_id' => 6,  // Lat Pulldown
                'sets' => 3,
                'reps' => 10,
            ],
            [
                'exercise_id' => 8,  // One Arm Cable Row
                'sets' => 3,
                'reps' => 12,
            ],
            [
                'exercise_id' => 7,  // Lat Pulldown Close Grip
                'sets' => 3,
                'reps' => 15,
            ],
            [
                'exercise_id' => 16, // Dumbbell Bicep Curl
                'sets' => 3,
                'reps' => 10,
            ],
        ],
    ],
    'Friday' => [
        'mainFocus' => 'Shoulders & Core',
        'exercises' => [
            [
                'exercise_id' => 22, // Overhead Dumbbell Shoulder Press
                'sets' => 3,
                'reps' => 10,
            ],
            [
                'exercise_id' => 23, // Dumbbell Side Lateral Raise
                'sets' => 3,
                'reps' => 12,
            ],
            [
                'exercise_id' => 25, // Dumbbell Front Raise
                'sets' => 3,
                'reps' => 15,
            ],
            [
                'exercise_id' => 20, // Hanging Leg Raise
                'sets' => 3,
                'reps' => '30s',
            ],
        ],
    ],
    'Saturday' => [
        'mainFocus' => 'Legs & Core',
        'exercises' => [
            [
                'exercise_id' => 14, // Lunges
                'sets' => 3,
                'reps' => 12,
            ],
            [
                'exercise_id' => 15, // Calf Raise
                'sets' => 3,
                'reps' => 15,
            ],
            [
                'exercise_id' => 17, // Dumbbell Hammer Curl
                'sets' => 3,
                'reps' => 12,
            ],
            [
                'exercise_id' => 24, // Dumbbell Rear Delt Fly
                'sets' => 3,
                'reps' => 15,
            ],
        ],
    ],
    'Sunday' => 'Rest day',
];



Route::get('/', function () {
    return Inertia::render('Welcome', [
        'daysOfWeek' => WorkoutPlanSets::getDayOptions(),
        'muscleGroups' => MuscleGroup::all(),
    ]);
});

Route::get('/workout-plan', function (Request $request) {
    $workoutPlan = WorkoutPlan::find($request->session()->get('workout_id'));
    if (!$workoutPlan) {
        return redirect('/')->with('error', 'No workout plan found');
    }
    $workoutPlanGroupedByDay = $workoutPlan->groupByDayWithFocusMuscles()->toArray();
    $daysOfWeek = WorkoutPlanSets::getDayOptions();

    foreach ($daysOfWeek as $day) {
        if (!array_key_exists($day, $workoutPlanGroupedByDay)) {
            $data[$day] = 'Rest day';
        }
    }

    return Inertia::render('WorkoutPlan', [
        'workoutPlan' => $daysOfWeek,
    ]);
});

Route::post('/generate', function (GenerateWorkoutRequest $request) use ($workoutPlan) {
    $workoutPlan = json_encode($workoutPlan);
    $data = $request->validated();
    $days = implode(', ', WorkoutPlanSets::getDayOptions());
    $duration = $data["duration"];
    $selectedMuscles = MuscleGroup::whereIn('id', $data['selectedMuscles'])->get();
    $focusMuscles = MuscleGroup::whereIn('id', $data["focusMuscles"])->get();
    $selectedDays =  implode(', ', $data["selectedDays"]);

    $availableExercises = collect(Exercise::all())->map(function ($exercise) {
        return [
            "id" => $exercise->id,
            "name" => $exercise->name,
            "trained_muscle_groups" => $exercise->trained_muscle_groups,
        ];
    });

    $open_ai = OpenAI::client(env("OPENAI_API_KEY"));
    while (true) {
        $response = $open_ai->chat()->create([
            "model" => "gpt-3.5-turbo-1106",
            "response_format" => [
                "type" => "json_object",
            ],
            "messages" => [
                [
                    "role" => "system",
                    "content" => "You are a helpful assistant designed to create an workoutplan with only the following exercises: {$availableExercises}. 
                    
                    The output should be a JSON object with the days as keys: {$days}.
                    All the days should be included in the object. (IMPORTANT)
    
                    If it is a rest day it should only be a string with the value 'Rest day'.
    
                    If it is a workout day it should be an object with the following keys: 'mainFocus', 'exercises'.
    
                    'mainFocus' - The main muscle groups that the user should focus on that day.
    
                    'exercises' - A list of exercises that the user should do that day. Each exercise should have a 'exercise_id', 'sets', and 'reps' key.
    
                    'exercise_id' - The id of the exercise that the user should do.
    
                    'sets' - The amount of sets that the user should do for the exercise (must be a number).
    
                    'reps' - The amount of reps that the user should do for the exercise (must be a number).
    
                    According to the duration of the workout, the amount of sets and reps should be adjusted accordingly.
    
                    min sets = 3
                    max sets = 6
    
                    min reps = 7
                    max reps = 20
    
                    Here is an example workoutplan: {$workoutPlan}
                    "
                ],
                [
                    "role" => "user",
                    "content" => "I want to generate a workout plan for the following muscle groups: {$selectedMuscles->pluck('name')->implode(', ')}. 
                    
                    I can only workout on the following days: {$selectedDays}. The rest should be rest days.
                    
                    I want to focus on the following muscle groups: {$focusMuscles->pluck('name')->implode(', ')}. 
                    
                    The duration of the workout should be {$duration} minutes."
                ]
            ],
            "max_tokens" => 4000,
        ]);

        $response_data = json_decode($response->choices[0]->message->content, true);


        if (isset($response_data[$data["selectedDays"][0]]['exercises'])) {
            break;
        }
        if (isset($response_data[$data["selectedDays"][0]]['exercises'])) {
            break;
        }
    }
    $response_data = array_change_key_case($data, CASE_LOWER);

    $daysOfWeek = WorkoutPlanSets::getDayOptions();

    foreach ($daysOfWeek as $day) {
        if (!array_key_exists($day, $response_data)) {
            $response_data[$day] = 'Rest day';
        }

        if (is_array($response_data[$day]) && isset($response_data[$day]['exercises'])) {
            foreach ($response_data[$day]['exercises'] as &$exercise) {
                $exercise['sets'] = (int) $exercise['sets'];

                if (is_numeric($exercise['reps'])) {
                    $exercise['reps'] = (int) $exercise['reps'];
                } else {
                    preg_match('/\d+/', $exercise['reps'], $matches);
                    if (isset($matches[0])) {
                        $exercise['reps'] = (int) $matches[0];
                    } else {
                        $exercise['reps'] = 0;
                    }
                }
            }
        }
    }
    logger($response_data);
    $workout = WorkoutPlan::create([
        'duration_minutes_per_session' => $duration,
    ]);

    foreach ($response_data as $day => $workoutData) {
        if ($workoutData === 'Rest day') {
            continue;
        }
        foreach ($workoutData['exercises'] as $exercise) {
            $workout->workoutPlanSets()->create([
                'sets' => $exercise['sets'],
                'reps' => $exercise['reps'],
                'exercise_id' => $exercise['exercise_id'],
                'day' => $day,
            ]);
        }
    }

    return redirect('/workout-plan')->with('workout_id', $workout->id);
});
