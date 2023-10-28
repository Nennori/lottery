<?php

namespace App\Providers;

use App\Events\MatchFinishedEvent;
use App\Events\MatchUserValidatedEvent;
use App\Events\WinnerChosenEvent;
use App\Listeners\AddMatchUserListener;
use App\Listeners\ChooseWinnerListener;
use App\Listeners\RewardWinnerListener;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        MatchFinishedEvent::class => [
            ChooseWinnerListener::class,
        ],

        WinnerChosenEvent::class => [
            RewardWinnerListener::class,
        ],

        MatchUserValidatedEvent::class => [
            AddMatchUserListener::class,
        ]
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
