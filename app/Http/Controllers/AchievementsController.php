<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AchievementList;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        // $user->load('badges', 'achievements');

        // // get all the unlocked achievements in a array
        // $unlockedAchievements = $user->achievements()->pluck('name')->toArray();

        // // get the next next_available_achievements for a user from the achievement list get only the one next in line from each catagory, noting the already unlock achievements
        // $nextAvailableAchievements = AchievementList::whereNotIn('name', $unlockedAchievements)->orderBy('category')->get();

        // // get the users current_badge
        // $currentBadge = $user->badges()->first();

        // // get the next_badge noting the current_badge
        // $nextBadge = $user->badges()->skip($currentBadge->id)->first();

        // // get the remaining_to_unlock_next_badge, count the user achievement and check against the next_badge condition
        // $remaingToUnlockNextBadge = $user->achievements()->count() - $nextBadge->condition;


        // return response()->json([
        //     'unlocked_achievements' => [],
        //     'next_available_achievements' => [],
        //     'current_badge' => '',
        //     'next_badge' => '',
        //     'remaing_to_unlock_next_badge' => 0
        // ]);

        // Eager load all necessary relationships
        $user->load(['badges', 'achievements']);

        // Get all unlocked achievements as a collection
        $unlockedAchievements = $user->achievements->pluck('name')->toArray();

        // Get the next available achievements for the user
        $nextAvailableAchievements = AchievementList::whereNotIn('name', $unlockedAchievements)
            ->orderBy('category')
            ->take(1) // Limit to only one next available achievement per category
            ->get(['name']);

        // Get the current badge and the next badge
        $currentBadge = $user->badges->first();
        $nextBadge = $user->badges->skip(1)->first();

        // Calculate the remaining achievements needed for the next badge
        $remainingToUnlockNextBadge = max(0, $nextBadge->condition - $user->achievements->count());

        return response()->json([
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => $currentBadge ? $currentBadge->name : null,
            'next_badge' => $nextBadge ? $nextBadge->name : null,
            'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge
        ]);
    }
}
