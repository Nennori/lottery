<?php

namespace App\Events;

use App\Models\LotteryGameMatch;
use Illuminate\Queue\SerializesModels;

class MatchUserValidatedEvent extends Event
{
    use SerializesModels;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public LotteryGameMatch $match, public $userId)
    {}
}
