<?php

namespace Database\Seeders;

use App\Models\AchievementList;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AchievementListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define achievement data
        $achievements = [
            ['category' => 'lesson', 'name' => 'First Lesson Watched', 'condition' => 1],
            ['category' => 'lesson', 'name' => '5 Lessons Watched', 'condition' => 5],
            ['category' => 'lesson', 'name' => '10 Lessons Watched', 'condition' => 10],
            ['category' => 'lesson', 'name' => '25 Lessons Watched', 'condition' => 25],
            ['category' => 'lesson', 'name' => '50 Lessons Watched', 'condition' => 50],
            ['category' => 'comment', 'name' => 'First Comment Written', 'condition' => 1],
            ['category' => 'comment', 'name' => '3 Comments Written', 'condition' => 3],
            ['category' => 'comment', 'name' => '5 Comments Written', 'condition' => 5],
            ['category' => 'comment', 'name' => '10 Comments Written', 'condition' => 10],
            ['category' => 'comment', 'name' => '20 Comments Written', 'condition' => 20],
        ];

        // Create achievements
        foreach ($achievements as $achievement) {
            AchievementList::create($achievement);
        }
    }
}
