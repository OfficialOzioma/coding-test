<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnlockCommentAchievementNotification
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

        // Check and unlock achievements based on lesson count
        if ($commentCount == 1) {
            $this->unlockAchievement($user, "First Comment Written");
        } elseif ($commentCount == 3) {
            $this->unlockAchievement($user, "3 Comments Written");
        } elseif ($commentCount == 5) {
            $this->unlockAchievement($user, "5 Comments Written");
        } elseif ($commentCount == 10) {
            $this->unlockAchievement($user, "10 Comments Written");
        } elseif ($commentCount == 20) {
            $this->unlockAchievement($user, "20 Comments Written");
        } else {
            $this->unlockAchievement($user, "Comment Written");
        }
    }

    protected function unlockAchievement($user, $achievementName)
    {
        // Attach the achievement to the user
        // $user->achievements()->attach(achievementId($achievementName));

        // Dispatch AchievementUnlocked event
        // event(new AchievementUnlocked($achievementName, $user));

        // Check for badge unlock
        // $this->checkBadgeUnlock($user);
    }

    protected function checkBadgeUnlock($user)
    {
        // Check if the user has enough achievements for a new badge
        $achievementCount = $user->achievements()->count();

        if ($achievementCount == 4) {
            $this->unlockBadge($user, "Intermediate");
        } elseif ($achievementCount == 8) {
            $this->unlockBadge($user, "Advanced");
        } elseif ($achievementCount == 10) {
            $this->unlockBadge($user, "Master");
        } else {
            $this->unlockBadge($user, "Beginner");
        }
    }

    protected function unlockBadge($user, $badgeName)
    {
        // Attach the badge to the user
        // $badgeId = badgeId($badgeName); // Replace with the actual logic to get badge ID
        // $user->badges()->syncWithoutDetaching([$badgeId]);

        // Dispatch BadgeUnlocked event
        // event(new BadgeUnlocked($badgeName, $user));
    }
}