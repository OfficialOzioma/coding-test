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
            // $this->unlockAchievement($user, $achievement->name);

            // Dispatch AchievementUnlocked event
            event(new AchievementUnlocked($achievement->name, $user));
        }

        // Check if the user has enough achievements for a new badge
        $achievementCount = $user->achievements()->count();

        // check the BadgeList to see if there is a match
        $badge = BadgeList::whereCondition($achievementCount)->first();

        if ($badge) {
            // $this->unlockBadge($user, $badgeList->name);
            // Dispatch BadgeUnlocked event
            event(new BadgeUnlocked($badge->name, $user));
        }



        // Check and unlock achievements based on lesson count
        // if ($commentCount == 1) {
        //     $this->unlockAchievement($user, "First Comment Written");
        // } elseif ($commentCount == 3) {
        //     $this->unlockAchievement($user, "3 Comments Written");
        // } elseif ($commentCount == 5) {
        //     $this->unlockAchievement($user, "5 Comments Written");
        // } elseif ($commentCount == 10) {
        //     $this->unlockAchievement($user, "10 Comments Written");
        // } elseif ($commentCount == 20) {
        //     $this->unlockAchievement($user, "20 Comments Written");
        // } else {
        //     $this->unlockAchievement($user, "Comment Written");
        // }
    }

    protected function unlockAchievement($user, $achievementName)
    {

        // find achievement from the achievement list
        // $achievementId = AchievementList::whereName($achievementName)->first()->id;

        // Attach the achievement to the user
        // $user->achievements()->attach($achievementId);

        // Dispatch AchievementUnlocked event
        // event(new AchievementUnlocked($achievementName, $user));

        // Check for badge unlock
        // $this->checkBadgeUnlock($user);
    }

    protected function checkBadgeUnlock($user)
    {
        // Check if the user has enough achievements for a new badge
        // $achievementCount = $user->achievements()->count();

        // if ($achievementCount == 4) {
        //     $this->unlockBadge($user, "Intermediate");
        // } elseif ($achievementCount == 8) {
        //     $this->unlockBadge($user, "Advanced");
        // } elseif ($achievementCount == 10) {
        //     $this->unlockBadge($user, "Master");
        // } else {
        //     $this->unlockBadge($user, "Beginner");
        // }
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
