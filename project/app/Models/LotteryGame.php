<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LotteryGame extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name', 'gamer_count', 'reward_points'
    ];

    public function matches(): HasMany
    {
        return $this->hasMany(LotteryGameMatch::class, 'game_id');
    }
}
