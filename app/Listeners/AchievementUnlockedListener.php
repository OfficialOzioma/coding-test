<?php

namespace App\Listeners;

use App\Models\AchievementList;
use App\Events\AchievementUnlocked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AchievementUnlockedListener
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
    public function handle(AchievementUnlocked $event): void
    {
        // Get the achievement name
        $achievementName = $event->achievementName;

        // find achievement from the achievement list
        $achievementId = AchievementList::whereName($achievementName)->first()->id;

        // Attach the achievement to the User
        $event->user->achievements()->attach($achievementId);
    }
}
