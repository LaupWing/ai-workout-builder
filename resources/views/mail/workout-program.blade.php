<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Workout Plan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .day-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e0e0e0;
            padding-top: 10px;
            margin-top: 10px;
        }

        .exercise-list {
            list-style-type: disc;
            padding-left: 20px;
        }

        .exercise-item {
            margin-bottom: 10px;
        }

        .workout-duration {
            color: #666;
            font-size: 14px;
        }

        .focus-muscles {
            background-color: #e0f7fa;
            color: #00796b;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
        }

        .italic {
            font-style: italic;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="title">
            <span>🏋️</span> Example Weekly Workout Plan
        </div>

        <p class="workout-duration">
            Workout Duration: {{ $workoutPlan['duration_minutes_per_session'] }} minutes per session
        </p>

        @foreach ($days as $day)
            @if (isset($groupedByDayWithFocusMuscles[$day]))
                @php
                    $weekData = $groupedByDayWithFocusMuscles[$day];
                @endphp
                <div class="day-header">
                    <h3>{{ ucfirst($day) }}</h3>
                    @if (is_array($weekData) && isset($weekData['focus_muscle_groups']))
                        <span class="focus-muscles">
                            {{ implode(', ', $weekData['focus_muscle_groups']->toArray()) }}
                        </span>
                    @endif
                </div>

                @if (is_array($weekData))
                    <ul class="exercise-list">
                        @foreach ($weekData['exercises']->toArray() as $exercise)
                            <li class="exercise-item">
                                {{ logger($exercise) }}
                                <div>
                                    <strong>{{ $exercise['sets'] }} x {{ $exercise['reps'] }}
                                        {{ $exercise['exercise']['name'] }}</strong>
                                    @if (!empty($exercise['exercise']['twitter_url']))
                                        <a href="{{ $exercise['exercise']['twitter_url'] }}" target="_blank">🔗</a>
                                    @endif
                                </div>
                                <span>Targets: {{ $exercise['exercise']['trained_muscles'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="italic">{{ $weekData }}</p>
                @endif
            @else
                <div class="day-header">
                    <h3>{{ ucfirst($day) }}</h3>
                    <p class="italic">Rest day</p>
                </div>
            @endif
        @endforeach
    </div>
</body>

</html>
