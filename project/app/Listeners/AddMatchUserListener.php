<?php

namespace App\Listeners;

use App\Events\MatchUserValidatedEvent;

class AddMatchUserListener
{
    /**
     * Handle the event.
     *
     * @param MatchUserValidatedEvent $event
     * @return void
     */
    public function handle(MatchUserValidatedEvent $event): void
    {
        $event->match->users()->attach($event->userId);
    }
}
