<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use App\Models\BadgeList;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BadgeUnlockedListener
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
    public function handle(BadgeUnlocked $event): void
    {
        // Get the badge ID
        $badgeId = BadgeList::whereName($event->badgeName)->first()->id;

        // Sync the specified badge with the user's badges without detaching any existing associations
        $event->user->badges()->syncWithoutDetaching($badgeId);
    }
}
