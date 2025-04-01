<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Tournament;
use App\Models\TournamentPlayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TournamentPlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $tournamentId)
    {
        //
        $validation = Validator::make($request->all(),[
        'name' => ['required', 'string'], 
        'email' => ['required', 'email']
    ]);
        if ($validation->fails()){
            return response()->json(["form failure" => $validation->errors()], 422);
        }
        // $alreadyin = TournamentPlayer::where('tournament_id', $tournamentId)->where('player_id', 2)->first();
        // dd($alreadyin);
        $player = Player::where('email', $request->email)->first();
        if(!$player){
            $player = new Player();
            $player->name = $request->name;
            $player->email = $request->email;
            $player->save();
        }
        $tournament = Tournament::find($tournamentId);
        if(!$tournament){
            return response()->json(["error" => "no tournament with this id"], 404);
        }
        $tournamentPlayer = new TournamentPlayer();
        $tournamentPlayer->tournament_id = $tournamentId;
        $tournamentPlayer->player_id = $player->id;
        $tournamentPlayer->save();
        return response()->json(["success" => "player added to tournament"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $tournamentId)
    {
        //
        $parsed = [];
        $tournament = Tournament::find($tournamentId);
        if(!$tournament){
            return response()->json(["error" => "no tournament with this id"], 404);
        }
        $tournamentPlayers = TournamentPlayer::where('tournament_id', $tournamentId)->get();
        foreach($tournamentPlayers as $entry){
            // dd($entry->player_id);
            Array_push($parsed, PlayerController::name($entry->player_id));
        }
        // dd($tournamentPlayers);
        return response()->json(["found" => $parsed], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $tournamentId, string $playerId)
    {
        $alreadyin = TournamentPlayer::where('tournament_id', $tournamentId)->where('player_id', $playerId)->first();
        if(!$alreadyin){
            return response()->json(["error" => "no tournament  or player with this id or registetred to the tournament with the given id"], 404);
        }
        $alreadyin->delete();
        return response()->json(["result" => "deleted player succesfuly"], 204);
    }
}
