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
        Schema::create('tournamentplayers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tournament_id');
            $table->bigInteger('player_id');
            $table->foreign('tournament_id')->references('id')->on('tournaments');
            $table->foreign('player_id')->references('id')->on('players');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournamentplayers');
    }
};
