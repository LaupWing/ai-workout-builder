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
                'muscle_group_id' => 1,
                'name' => 'Bench Press',
                'twitter_url' => 'https://twitter.com/search?q=Bench%20Press'
            ],

        ];
    }
}
