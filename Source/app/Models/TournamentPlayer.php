<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentPlayer extends Model
{
    //
    protected $table = 'tournamentplayers';
    protected $fillable = ['tournament_id', 'player_id'];
}
