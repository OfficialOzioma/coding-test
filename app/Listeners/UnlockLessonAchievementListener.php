<?php

namespace App\Listeners;

use App\Models\BadgeList;
use App\Events\BadgeUnlocked;
use App\Events\LessonWatched;
use App\Models\AchievementList;
use App\Events\AchievementUnlocked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnlockLessonAchievementListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LessonWatched $event): void
    {
        // $event->user->achievements()->attach();
        $lessonWatched = $event->user->watched()->count();

        // check if any achievements have been matched
        $achievement = AchievementList::whereCategory('Lesson')->whereCondition($lessonWatched)->first();

        if ($achievement) {
            event(new AchievementUnlocked($achievement->name, $event->user));
        }

        // Check if the user has enough achievements for a new badge
        $achievementCount = $event->user->achievements()->count();

        // check the BadgeList to see if there is a match
        $badge = BadgeList::whereCondition($achievementCount)->first();


        if ($badge) {
            event(new BadgeUnlocked($badge->name, $event->user));
        }
    }
}
