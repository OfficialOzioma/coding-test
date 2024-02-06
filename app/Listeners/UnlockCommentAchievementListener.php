<?php

namespace App\Listeners;

use App\Models\BadgeList;
use App\Events\BadgeUnlocked;
use App\Events\CommentWritten;
use App\Models\AchievementList;
use App\Events\AchievementUnlocked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnlockCommentAchievementListener
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
    public function handle(CommentWritten $event): void
    {
        $user = $event->comment->user;

        // check the number of comment by the user;
        $commentCount = $user->comment_count;

        // Check the achievements that match with the comment count
        $achievement = AchievementList::whereCategory('Comment')->whereCondition($commentCount)->first();

        // if there is a match unlock an achievement
        if ($achievement) {
            // Dispatch AchievementUnlocked event
            event(new AchievementUnlocked($achievement->name, $user));
        }

        // Check if the user has enough achievements for a new badge
        $achievementCount = $user->achievements()->count();

        // check the BadgeList to see if there is a match
        $badge = BadgeList::whereCondition($achievementCount)->first();

        if ($badge) {
            // Dispatch BadgeUnlocked event
            event(new BadgeUnlocked($badge->name, $user));
        }
    }
}
