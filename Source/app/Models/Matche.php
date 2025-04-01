<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matche extends Model
{
    //
    protected $fillable = ['name' , 'tournament_id', 'score', 'player_id'];
}
