<?php

namespace App\Http\Controllers;

use App\Models\LotteryGame;
use Illuminate\Database\Eloquent\Collection;

class LotteryGameController extends Controller
{
    public function index(): Collection
    {
        return LotteryGame::all();
    }
}
