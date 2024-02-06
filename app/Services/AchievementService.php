<?php

namespace App\Services;

use App\Models\User;
use App\Models\BadgeList;
use App\Models\AchievementList;

class AchievementService
{
    public function getNextAchievements(User $user): array
    {
        // Get the highest achieved conditions for each category using relationships
        $highestCommentCondition = $user->achievements()
            ->where('category', 'comment')
            ->max('condition');

        $highestLessonCondition = $user->achievements()
            ->where('category', 'lesson')
            ->max('condition');

        // Get the next achievements for each category
        $nextCommentAchievement = AchievementList::where('category', 'comment')
            ->where('condition', '>', $highestCommentCondition ?? 0)
            ->orderBy('condition')
            ->first()->toArray();

        $nextLessonAchievement = AchievementList::where('category', 'lesson')
            ->where('condition', '>', $highestLessonCondition ?? 0)
            ->orderBy('condition')
            ->first()->toArray();

        return [
            'comment' => $nextCommentAchievement['name'],
            'lesson' => $nextLessonAchievement['name'],
        ];
    }

    public function nextBadge(User $user)
    {
        // Get the condition of the user's current badge
        $currentBadgeCondition = $user->badges()->value('condition');

        // Find the next badge with a condition greater than the current badge's condition
        $nextBadge = BadgeList::where('condition', '>', $currentBadgeCondition ?? 0)
            ->orderBy('condition')
            ->first();

        // Return the name of the next badge, if exists
        return $nextBadge;
    }
}
