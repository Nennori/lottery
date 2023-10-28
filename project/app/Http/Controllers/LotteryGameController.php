<?php

namespace App\Http\Controllers;

use App\Models\LotteryGame;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class LotteryGameController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['message' => 'Success', 'data' => LotteryGame::all()]);
    }
}
