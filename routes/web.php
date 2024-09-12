<?php

use App\Http\Requests\GenerateWorkoutRequest;
use App\Models\Exercise;
use App\Models\MuscleGroup;
use App\Models\WorkoutPlanSets;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    $duration = $data["duration"];
    $selectedMuscles = MuscleGroup::whereIn('id', $data['selectedMuscles'])->get();
    $focusMuscles = MuscleGroup::whereIn('id', $data["focusMuscles"])->get();
    $selectedDays = $data["selectedDays"];

    // if (count($focusMuscles) > 0) {
    //     $selectedMuscles = $selectedMuscles->merge($focusMuscles);
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
    // Monday: {
    //     mainFocus: 'Chest & Triceps',
    //     exercises: [
    //         {
    //             name: '3 x 10 Bench Press',
    //             muscleGroup: 'Chest',
    //             videoLink:
    //                 'https://twitter.com/youraccount/status/benchpress',
    //         },
    //         {
    //             name: '3 x 12 Incline Dumbbell Press',
    //             muscleGroup: 'Upper Chest',
    //             videoLink:
    //                 'https://twitter.com/youraccount/status/inclinepress',
    //         },
    //         {
    //             name: '3 x 15 Push-ups',
    //             muscleGroup: 'Chest, Shoulders, Triceps',
    //             videoLink: 'https://twitter.com/youraccount/status/pushups',
    //         },
    //         {
    //             name: '3 x 12 Tricep Pushdowns',
    //             muscleGroup: 'Triceps',
    //             videoLink:
    //                 'https://twitter.com/youraccount/status/triceppushdowns',
    //         },
    //     ],
    // },
    // Tuesday: {
    //     mainFocus: 'Legs & Core',
    //     exercises: [
    //         {
    //             name: '3 x 10 Squats',
    //             muscleGroup: 'Quadriceps, Glutes, Hamstrings',
    //             videoLink: 'https://twitter.com/youraccount/status/squats',
    //         },
    //         {
    //             name: '3 x 12 Lunges',
    //             muscleGroup: 'Quadriceps, Glutes, Hamstrings',
    //             videoLink: 'https://twitter.com/youraccount/status/lunges',
    //         },
    //         {
    //             name: '3 x 15 Leg Press',
    //             muscleGroup: 'Quadriceps, Glutes',
    //             videoLink:
    //                 'https://twitter.com/youraccount/status/legpress',
    //         },
    //         {
    //             name: '3 x 20 Crunches',
    //             muscleGroup: 'Core',
    //             videoLink:
    //                 'https://twitter.com/youraccount/status/crunches',
    //         },
    //     ],
    // },
    // Wednesday: 'Rest day',
    // Thursday: {
    //     mainFocus: 'Back & Biceps',
    //     exercises: [
    //         {
    //             name: '3 x 10 Pull-ups',
    //             muscleGroup: 'Back, Biceps',
    //             videoLink: 'https://twitter.com/youraccount/status/pullups',
    //         },
    //         {
    //             name: '3 x 12 Bent-over Rows',
    //             muscleGroup: 'Back',
    //             videoLink:
    //                 'https://twitter.com/youraccount/status/bentoverrows',
    //         },
    //         {
    //             name: '3 x 15 Lat Pulldowns',
    //             muscleGroup: 'Back, Biceps',
    //             videoLink:
    //                 'https://twitter.com/youraccount/status/latpulldowns',
    //         },
    //         {
    //             name: '3 x 10 Bicep Curls',
    //             muscleGroup: 'Biceps',
    //             videoLink:
    //                 'https://twitter.com/youraccount/status/bicepcurls',
    //         },
    //     ],
    // },
    // Friday: {
    //     mainFocus: 'Shoulders & Core',
    //     exercises: [
    //         {
    //             name: '3 x 10 Military Press',
    //             muscleGroup: 'Shoulders',
    //             videoLink:
    //                 'https://twitter.com/youraccount/status/militarypress',
    //         },
    //         {
    //             name: '3 x 12 Lateral Raises',
    //             muscleGroup: 'Lateral Deltoids',
    //             videoLink:
    //                 'https://twitter.com/youraccount/status/lateralraises',
    //         },
    //         {
    //             name: '3 x 15 Front Raises',
    //             muscleGroup: 'Front Deltoids',
    //             videoLink:
    //                 'https://twitter.com/youraccount/status/frontraises',
    //         },
    //         {
    //             name: '3 x 30s Plank',
    //             muscleGroup: 'Core',
    //             videoLink: 'https://twitter.com/youraccount/status/plank',
    //         },
    //     ],
    // },
    // Saturday: {
    //     mainFocus: 'Legs & Core',
    //     exercises: [
    //         {
    //             name: '3 x 12 Lunges',
    //             muscleGroup: 'Quadriceps, Glutes, Hamstrings',
    //             videoLink: 'https://twitter.com/youraccount/status/lunges',
    //         },
    //         {
    //             name: '3 x 15 Leg Press',
    //             muscleGroup: 'Quadriceps, Glutes',
    //             videoLink:
    //                 'https://twitter.com/youraccount/status/legpress',
    //         },
    //         {
    //             name: '3 x 12 Calf Raises',
    //             muscleGroup: 'Calves',
    //             videoLink:
    //                 'https://twitter.com/youraccount/status/calfraises',
    //         },
    //         {
    //             name: '3 x 15 Russian Twists',
    //             muscleGroup: 'Core, Obliques',
    //             videoLink:
    //                 'https://twitter.com/youraccount/status/russiantwists',
    //         },
    //     ],
    // },
    // Sunday: 'Rest day',
    $response = $open_ai->chat()->create([
        "model" => "gpt-3.5-turbo-1106",
        "response_format" => [
            "type" => "json_object",
        ],
        "messages" => [
            [
                "role" => "system",
                "content" => "You are a helpful assistant designed to create an workoutplan with only the following exercises: {$availableExercises}. 
                
                The output should be a JSON object with the following keys: 'protein', 'bodyfat', 'calories', 'meal_plan'.

                'protein' - The amount of protein in grams that the user should consume daily.

                'current_bodyfat' - The exact current bodyfat percentage the user has as a number.

                'goal_bodyfat' - The exact bodyfat percentage the user aim for as a number.

                'calories' - The amount of calories that the user should consume daily.

                'meal_plan' - A list of meals that the user should consume daily. Each meal should have a 'recipe_name'(name of the recipe),'calories', and 'meal_type'(breakfast, lunch, diner, or snack) key.

                "
            ],
            // [
            //     "role" => "user",
            //     "content" => "I'm a $gender and $age years old. I'm $height cm tall and weigh $weight $unit. I'm $activity and I want to reach $goal_weight $unit in $goal_months months."
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
    //     "age" => $age,
    //     "gender" => $gender,
    //     "height" => $height,
    //     "weight" => $weight,
    //     "activity" => $activity,
    //     "goal_weight" => $goal_weight,
    //     "goal_months" => $goal_months,
    //     "unit" => $unit,
    // ]);

    // $activities = [
    //     "sedentary" => "Little or no exercise.",
    //     "lightly" => "Light exercise 1-3 days a week.",
    //     "moderately" => "Moderate 3-5 days a week.",
    //     "very" => "Hard exercise 6-7 days a week.",
    //     "extra" => "Very hard exercise or physical job.",
    // ];

    // $activity = $activities[$activity];

    // $data = json_decode($response->choices[0]->message->content);
    // return redirect(route("generated"))->with("data", $data)->with("guest_id", $guest->id);
    return redirect()->back();
});
