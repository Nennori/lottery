<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class WinnerChosenEvent extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public User $user, public int $rewardPoints)
    {}
}
