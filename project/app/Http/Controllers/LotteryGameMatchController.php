<?php

namespace App\Http\Controllers;

use App\Models\LotteryGameMatch;
use Illuminate\Http\Request;

class LotteryGameMatchController extends Controller
{
    public function store(Request $request): void
    {
        $this->validate($request, LotteryGameMatch::storeValidationRules());

        LotteryGameMatch::createMatch($request->only(['game_id', 'start_date', 'start_time', 'winner_id']));
    }

    public function index(Request $request)
    {
        return LotteryGameMatch::listMatches($request->only('lottery_game_id'));
    }

    public function finishMatch(Request $request): void
    {
        $this->validate($request, LotteryGameMatch::FINISH_MATCH_VALIDATION_RULES);

        LotteryGameMatch::finishMatch($request->only('match_id'));
    }

    public function addUser(Request $request)
    {
        $this->validate($request, LotteryGameMatch::ADD_USER_VALIDATION_RULES);

        LotteryGameMatch::addUser($request->only(['match_id', 'user_id']));
    }
}
