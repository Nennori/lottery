<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LotteryGameMatch extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'start_date', 'start_time', 'is_finished'
    ];

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(LotteryGame::class, 'game_id');
    }


    public function gamers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lottery_game_match_users');
    }
}
