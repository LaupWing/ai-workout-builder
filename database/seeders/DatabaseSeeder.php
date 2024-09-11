<?php

namespace Database\Seeders;

use App\Models\MuscleGroup;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $muscleGroups = ['chest', 'back', 'legs', 'arms', 'shoulders', 'core'];

        foreach ($muscleGroups as $muscleGroup) {
            MuscleGroup::create(['name' => $muscleGroup]);
        }
        $exercises = [
            [
                'muscle_group' => 'chest',
                'name' => 'Bench Press',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440038615535782',
                'trained_muscle_groups' => 'Chest, Shoulders, Triceps'
            ],
            [
                'muscle_group' => 'chest',
                'name' => 'Incline Dumbbell Press',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440042642014417',
                'trained_muscle_groups' => 'Upper Chest, Shoulders, Triceps'
            ],
            [
                'muscle_group' => 'chest',
                'name' => 'Cable Chest Fly',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440046471483810',
                'trained_muscle_groups' => 'Chest'
            ],
            [
                'muscle_group' => 'chest',
                'name' => 'Cable Chest Fly High Low',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440049910796728',
                'trained_muscle_groups' => 'Chest, Lower Chest'
            ],
            [
                'muscle_group' => 'chest',
                'name' => 'Machine Chest Press',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440053354299546',
                'trained_muscle_groups' => 'Chest, Shoulders, Triceps'
            ],
            [
                'muscle_group' => 'back',
                'name' => 'Lat Pulldown',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440591043080319',
                'trained_muscle_groups' => 'Lats, Biceps, Upper Back'
            ],
            [
                'muscle_group' => 'back',
                'name' => 'Lat Pulldown Close Grip',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440594461503872',
                'trained_muscle_groups' => 'Lats, Biceps'
            ],
            [
                'muscle_group' => 'back',
                'name' => 'Bent Over Barbell Row',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440597925953744',
                'trained_muscle_groups' => 'Lats, Upper Back, Biceps'
            ],
            [
                'muscle_group' => 'back',
                'name' => 'One Arm Cable Row',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440600929100250',
                'trained_muscle_groups' => 'Lats, Upper Back, Biceps'
            ],
            [
                'muscle_group' => 'back',
                'name' => 'One Arm Dumbbell Row',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440603605049823',
                'trained_muscle_groups' => 'Lats, Upper Back, Biceps'
            ],
            [
                'muscle_group' => 'legs',
                'name' => 'Barbell Squat',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440609137377748',
                'trained_muscle_groups' => 'Quads, Hamstrings, Glutes'
            ],
            [
                'muscle_group' => 'legs',
                'name' => 'Leg Extension',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440611767148803',
                'trained_muscle_groups' => 'Quads'
            ],
            [
                'muscle_group' => 'legs',
                'name' => 'Stiff Leg Deadlift',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440615110062544',
                'trained_muscle_groups' => 'Hamstrings, Glutes, Lower Back'
            ],
            [
                'muscle_group' => 'legs',
                'name' => 'Lunges',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440617966350516',
                'trained_muscle_groups' => 'Quads, Glutes, Hamstrings'
            ],
            [
                'muscle_group' => 'legs',
                'name' => 'Calf Raise',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440620969455907',
                'trained_muscle_groups' => 'Calves'
            ],
            [
                'muscle_group' => 'arms',
                'name' => 'Dumbbell Bicep Curl',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791442306895122876',
                'trained_muscle_groups' => 'Biceps'
            ],
            [
                'muscle_group' => 'arms',
                'name' => 'Dumbbell Hammer Curl',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791442311261339708',
                'trained_muscle_groups' => 'Biceps, Brachialis'
            ],
            [
                'muscle_group' => 'arms',
                'name' => 'Dumbbell Skull Crusher',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791442314574942333',
                'trained_muscle_groups' => 'Triceps'
            ],
            [
                'muscle_group' => 'arms',
                'name' => 'Cable Rope Tricep Extension',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791442318668763565',
                'trained_muscle_groups' => 'Triceps'
            ],
            [
                'muscle_group' => 'core',
                'name' => 'Hanging Leg Raise',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791442324922237037',
                'trained_muscle_groups' => 'Abs, Hip Flexors'
            ],
            [
                'muscle_group' => 'core',
                'name' => 'Cable Crunch',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791442327950528901',
                'trained_muscle_groups' => 'Abs'
            ],
            [
                'muscle_group' => 'shoulders',
                'name' => 'Overhead Dumbbell Shoulder Press',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440626367471790',
                'trained_muscle_groups' => 'Shoulders, Triceps'
            ],
            [
                'muscle_group' => 'shoulders',
                'name' => 'Dumbbell Side Lateral Raise',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440630159151155',
                'trained_muscle_groups' => 'Shoulders'
            ],
            [
                'muscle_group' => 'shoulders',
                'name' => 'Dumbbell Rear Delt Fly',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440632726147349',
                'trained_muscle_groups' => 'Rear Shoulders'
            ],
            [
                'muscle_group' => 'shoulders',
                'name' => 'Dumbbell Front Raise',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791442301538980318',
                'trained_muscle_groups' => 'Front Shoulders'
            ]
        ];

        foreach ($exercises as $exercise) {
            $muscleGroup = MuscleGroup::where('name', $exercise['muscle_group'])->first();
            $muscleGroup->exercises()->create([
                'name' => $exercise['name'],
                'twitter_url' => $exercise['twitter_url'],
                'trained_muscle_groups' => $exercise['trained_muscle_groups']
            ]);
        }
    }
}
