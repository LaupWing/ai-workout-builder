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
            ]
        ];
    }
}
