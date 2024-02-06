<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\BadgeList;
use App\Models\UserBadge;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\CommentWritten;
use App\Models\AchievementList;
use App\Services\AchievementService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;

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

        // Get the next badge
        $nextBadge = $achievementService->nextBadge($user);

        // Get the condition for the next badge
        $condition = $nextBadge ? $nextBadge->condition : 0;

        // Calculate the remaining achievements needed for the next badge
        $remainingToUnlockNextBadge = max(0, $condition - $user->achievements->count());

        // Return the response
        return response()->json([
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => $currentBadge ? $currentBadge->name : null,
            'next_badge' => $nextBadge ? $nextBadge->name : null,
            'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge
        ]);
    }
}
