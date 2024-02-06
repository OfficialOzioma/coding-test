<?php

namespace Database\Seeders;

use App\Models\BadgeList;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BadgeListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define badge names
        $badges = [
            ['name' => 'Beginner', 'condition' => 0],
            ['name' => 'Intermediate', 'condition' => 4],
            ['name' => 'Advanced', 'condition' => 8],
            ['name' => 'Master', 'condition' => 10],
        ];

        // Create badges
        foreach ($badges as $badge) {
            BadgeList::create($badge);
        }
    }
}
