<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lottery_games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('gamer_count')->default(0);
            $table->unsignedInteger('reward_points');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lottery_games');
    }
};
