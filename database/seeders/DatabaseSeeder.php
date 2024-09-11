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
        [
            [
                'muscle_group' => 'chest',
                'name' => 'Bench Press',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440038615535782'
            ],
            [
                'muscle_group' => 'chest',
                'name' => 'Incline Dumbbell Press',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440042642014417'
            ],
            [
                'muscle_group' => 'chest',
                'name' => 'Cable Chest Fly',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440046471483810'
            ],
            [
                'muscle_group' => 'chest',
                'name' => 'Cable Chest Fly High Low',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440049910796728'
            ],
            [
                'muscle_group' => 'chest',
                'name' => 'Machine Chest Press',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440053354299546'
            ],
            [
                'muscle_group' => 'back',
                'name' => 'Lat Pulldown',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440591043080319'
            ],
            [
                'muscle_group' => 'back',
                'name' => 'Lat Pulldown Close Grip',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440594461503872'
            ],
            [
                'muscle_group' => 'back',
                'name' => 'Bent Over Barbell Row',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440597925953744'
            ],
            [
                'muscle_group' => 'back',
                'name' => 'One Arm Cable Row',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440600929100250'
            ],
            [
                'muscle_group' => 'back',
                'name' => 'One Arm Dumbbell Row',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440603605049823'
            ],
            [
                'muscle_group' => 'legs',
                'name' => 'Barbell Squat',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440609137377748'
            ],
            [
                'muscle_group' => 'legs',
                'name' => 'Leg Extension',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440611767148803'
            ],
            [
                'muscle_group' => 'legs',
                'name' => 'Stiff Leg Deadlift',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440615110062544'
            ],
            [
                'muscle_group' => 'legs',
                'name' => 'Lunges',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440617966350516'
            ],
            [
                'muscle_group' => 'legs',
                'name' => 'Calf Raise',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440620969455907'
            ],
            [
                'muscle_group' => 'arms',
                'name' => 'Dumbbell Bicep Curl',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791442306895122876'
            ],
            [
                'muscle_group' => 'arms',
                'name' => 'Dumbbell Hammer Curl',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791442311261339708'
            ],
            [
                'muscle_group' => 'arms',
                'name' => 'Dumbbel Skull Crusher',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791442314574942333'
            ],
            [
                'muscle_group' => 'arms',
                'name' => 'Cable Rope Tricep Extension',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791442318668763565'
            ],
            [
                'muscle_group' => 'core',
                'name' => 'Hanging Leg Raise',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791442324922237037'
            ],
            [
                'muscle_group' => 'core',
                'name' => 'Cable Crunch',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791442327950528901'
            ],
            [
                'muscle_group' => 'shoulders',
                'name' => 'Overhead Dumbbell Shoulder Press',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440626367471790'
            ],
            [
                'muscle_group' => 'shoulders',
                'name' => 'Dumbbell Side Lateral Raise',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440630159151155'
            ],
            [
                'muscle_group' => 'shoulders',
                'name' => 'Dumbbell Reare Delt Fly',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791440632726147349'
            ],
            [
                'muscle_group' => 'shoulders',
                'name' => 'Dumbbell Front Raise',
                'twitter_url' => 'https://x.com/LaupWing1994/status/1791442301538980318'
            ]
        ];
    }
}
