<?php

namespace App\Listeners;

use App\Events\WinnerChosenEvent;

class RewardWinnerListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {}

    /**
     * Handle the event.
     *
     * @param WinnerChosenEvent $event
     * @return void
     */
    public function handle(WinnerChosenEvent $event): void
    {
        $event->user->points += $event->rewardPoints;
        $event->user->save();
    }
}
