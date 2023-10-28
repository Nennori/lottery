<?php

namespace App\Http\Controllers;

use App\Models\LotteryGameMatch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LotteryGameMatchController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, LotteryGameMatch::storeValidationRules());

        LotteryGameMatch::createMatch($request->only(['game_id', 'start_date', 'start_time', 'winner_id']));

        return response()->json(['message' => 'Success', 'data' => []]);
    }

    public function index(Request $request)
    {
        return response()->json(['message' => 'Success', 'data' => LotteryGameMatch::listMatches($request->only('lottery_game_id'))]);
    }

    public function finishMatch(Request $request): JsonResponse
    {
        $this->validate($request, LotteryGameMatch::FINISH_MATCH_VALIDATION_RULES);

        LotteryGameMatch::finishMatch($request->only('match_id'));

        return response()->json(['message' => 'Success', 'data' => []]);
    }

    public function addUser(Request $request)
    {
        $this->validate($request, LotteryGameMatch::ADD_USER_VALIDATION_RULES);

        LotteryGameMatch::addUser($request->only(['match_id', 'user_id']));

        return response()->json(['message' => 'Success', 'data' => []]);
    }
}
