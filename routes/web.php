<?php

use App\Http\Requests\GenerateWorkoutRequest;
use App\Models\Exercise;
use App\Models\MuscleGroup;
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

?>


Route::get('/', function () {
return Inertia::render('Welcome', [
'daysOfWeek' => WorkoutPlanSets::getDayOptions(),
'muscleGroups' => MuscleGroup::all(),
]);
});

Route::get('/workout-plan', function () {
return Inertia::render('WorkoutPlan');
});

Route::post('/generate', function (GenerateWorkoutRequest $request) {
$data = $request->validated();
$days = WorkoutPlanSets::getDayOptions();
$duration = $data["duration"];
$selectedMuscles = MuscleGroup::whereIn('id', $data['selectedMuscles'])->get();
$focusMuscles = MuscleGroup::whereIn('id', $data["focusMuscles"])->get();
$selectedDays = $data["selectedDays"];

// if (count($focusMuscles) > 0) {
// $selectedMuscles = $selectedMuscles->merge($focusMuscles);
// }
$availableExercises = collect(Exercise::all())->map(function ($exercise) {
return [
"id" => $exercise->id,
"name" => $exercise->name,
"trained_muscle_groups" => $exercise->trained_muscle_groups,
];
});
logger("");

$open_ai = OpenAI::client(env("OPENAI_API_KEY"));

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

If it is a rest day it should only be a string with the value 'Rest day'.

If it is a workout day it should be an object with the following keys: 'mainFocus', 'exercises'.

'mainFocus' - The main muscle groups that the user should focus on that day.

'exercises' - A list of exercises that the user should do that day. Each exercise should have a 'exercise_id', 'sets', and 'reps' key.

'exercise_id' - The id of the exercise that the user should do.

'sets' - The amount of sets that the user should do for the exercise.

'reps' - The amount of reps that the user should do for the exercise.
"
],
// [
// "role" => "user",
// "content" => "I'm a $gender and $age years old. I'm $height cm tall and weigh $weight $unit. I'm $activity and I want to reach $goal_weight $unit in $goal_months months."
// ]
],
"max_tokens" => 4000,
]);

return redirect()->back();
});

Route::post('/generate-workout-plan', function (Request $request) {
logger($request->all());
// $age = $data["age"];
// $gender = $data["gender"];
// $height = $data["height"];
// $weight = $data["weight"];
// $activity = $data["activity"];
// $goal_weight = $data["goal_weight"];
// $goal_months = $data["goal_months"];
// $unit = $data["unit"];

// $guest = Guest::create([
// "age" => $age,
// "gender" => $gender,
// "height" => $height,
// "weight" => $weight,
// "activity" => $activity,
// "goal_weight" => $goal_weight,
// "goal_months" => $goal_months,
// "unit" => $unit,
// ]);

// $activities = [
// "sedentary" => "Little or no exercise.",
// "lightly" => "Light exercise 1-3 days a week.",
// "moderately" => "Moderate 3-5 days a week.",
// "very" => "Hard exercise 6-7 days a week.",
// "extra" => "Very hard exercise or physical job.",
// ];

// $activity = $activities[$activity];

// $data = json_decode($response->choices[0]->message->content);
// return redirect(route("generated"))->with("data", $data)->with("guest_id", $guest->id);
return redirect()->back();
});