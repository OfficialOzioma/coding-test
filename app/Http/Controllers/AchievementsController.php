<?php

namespace App\Http\Controllers;

use App\Services\AchievementService;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AchievementList;
use App\Models\BadgeList;
use App\Models\UserBadge;

class AchievementsController extends Controller
{
    public function index(User $user, AchievementService $achievementService)
    {
        // Get all unlocked achievements as a collection
        $unlockedAchievements = $user->achievements->pluck('name')->toArray();

        // Get the next available achievements for the user
        $nextAvailableAchievements = $achievementService->getNextAchievements($user);

        // Get the current badge and the next badge
        $currentBadge = $user->badges->first();

        $nextBadge = $achievementService->nextBadge($user);

        // Calculate the remaining achievements needed for the next badge
        $remainingToUnlockNextBadge = max(0, $nextBadge->condition - $user->achievements->count());
        // $remainingToUnlockNextBadge = $achievementService->nextBadgeCondition($user);



        return response()->json([
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => $currentBadge ? $currentBadge->name : null,
            'next_badge' => $nextBadge ? $nextBadge->name : null,
            'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge
        ]);
    }
}
