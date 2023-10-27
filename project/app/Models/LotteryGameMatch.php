<?php

namespace App\Models;

use App\Events\MatchFinishedEvent;
use App\Events\MatchUserValidatedEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LotteryGameMatch extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'start_date', 'start_time', 'is_finished', 'game_id', 'winner_id'
    ];

    const FINISH_MATCH_VALIDATION_RULES = [
        'match_id' => 'required|numeric|exists:lottery_game_matches,id',
    ];

    const ADD_USER_VALIDATION_RULES = [
        'match_id' => 'required|numeric|exists:lottery_game_matches,id',
        'user_id' => 'required|numeric|exists:users,id',
    ];

    public static function storeValidationRules(): array
    {
        return [
            'game_id' => 'required|numeric|exists:lottery_games,id',
            'start_date' => ['date_format:Y-m-d', 'after_or_equal:' . date('Y-m-d')],
            'start_time' => 'date_format:H:i',
            'winner_id' => 'numeric|exists:users,id'
        ];
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(LotteryGame::class, 'game_id');
    }


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lottery_game_match_users');
    }

    public static function createMatch($data)
    {
        return LotteryGameMatch::create($data);
    }

    public static function finishMatch($data)
    {
        $match = LotteryGameMatch::find($data['match_id']);

        $match->is_finished = true;
        $match->save();

        event(new MatchFinishedEvent($match));

        return $match;
    }

    public static function addUser($data)
    {
        $match = LotteryGameMatch::find($data['match_id']);
        $userId = $data['user_id'];

        if ($match->userNotAddedToMatch($userId) && $match->userGameLimitNotReached()) {
            event(new MatchUserValidatedEvent($match, $userId));
        }

        return $match;
    }

    public static function listMatches($gameId)
    {
        return self::where('game_id', $gameId)->get();
    }

    private function userNotAddedToMatch($userId): bool
    {
        return $this->users()->where('user_id', $userId)->first() == null;
    }

    private function userGameLimitNotReached(): bool
    {
        return $this->users()->count() < $this->game()->value('gamer_count');
    }
}
