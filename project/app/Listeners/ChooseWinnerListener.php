<?php

namespace App\Listeners;

use App\Events\MatchFinishedEvent;
use App\Events\WinnerChosenEvent;

class ChooseWinnerListener
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
     * @param MatchFinishedEvent $event
     * @return void
     */
    public function handle(MatchFinishedEvent $event): void
    {
        $user = $event->match->users()->inRandomOrder()->first();

        if (null != $user) {
            $event->match->winner()->associate($user)->save();
            event(new WinnerChosenEvent($user, $event->match->game()->value('reward_points')));
        }
    }
}
