<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lesson;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\BadgeList;
use App\Models\AchievementList;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the BadgeListSeeder
        $this->call(BadgeListSeeder::class);

        // Call the AchievementListSeeder
        $this->call(AchievementListSeeder::class);

        // Get badge IDs
        $badgeIds = BadgeList::pluck('id');

        // Get achievement lists
        $achievements = AchievementList::all();

        $lessons = Lesson::factory()
            ->count(20)
            ->create();


        // Create users and associate them to lessons they have watched, used model has watched many to many relationship with user_lesson as pivote table
        $users = User::factory()
            ->count(10)
            ->create();

        foreach ($users as $user) {
            // $lessons = Lesson::inRandomOrder()
            //     ->limit(rand(1, 5))
            //     ->get();

            // Create a comment for the user
            Comment::factory()->count(rand(1, 20))->create();

            // Update user's comment count
            $user->update(['comment_count' => $user->comments()->count()]);
            // Get random lessons for the user to watch
            $watchedLessons = $lessons->random(rand(1, 5));


            // $user->watched()->attach($lessons);
            // Attach the lessons to the user with the 'watched' field set to true in the pivot table
            $user->watched()->attach($watchedLessons, ['watched' => true]);


            // Assign achievements based on the number of lessons watched
            $lessonsWatched = $user->watched()->count();
            $lessonsAchievements = AchievementList::whereCategory('lesson')
                ->whereCondition($lessonsWatched)
                ->pluck('id');
            $user->achievements()->attach($lessonsAchievements);

            // Assign achievements based on the user's comment count
            $commentCount = $user->comment_count;
            $commentAchievements = AchievementList::whereCategory('comment')
                ->whereCondition($commentCount)
                ->pluck('id');
            $user->achievements()->attach($commentAchievements);

            // Assign badges based on the number of achievements
            $achievementCount = $user->achievements()->count();
            $badgesToAssign = BadgeList::whereCondition($achievementCount)->pluck('id');
            $user->badges()->syncWithoutDetaching($badgesToAssign);
        }
    }
}
