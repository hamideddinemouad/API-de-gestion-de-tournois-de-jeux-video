<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Matche;
use App\Models\Player;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MatcheController extends Controller
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
    public function store(Request $request)
    {
        //
        $validation = Validator::make($request->all(),
        ['name' => ['required', 'string'],
        'tournamentName' => ['required', 'string', 'exists:tournaments,name'],
        'score' => ['int'],
        'playeremail' => ['nullable', 'array'],
        'playeremail.*' => ['email', 'exists:players,email'],
    ]);

    if ($validation->fails()){
        return response()->json(["error" => $validation->errors()], 422);
    }


    foreach($request->playeremail as $email){
        $entry = new Matche();
        $entry->name = $request->name;
        $entry->player_id = Player::where('email', $email)->first()->id;
        $entry->tournament_id = Tournament::where('name', $request->tournamentName)->first();
        $entry->score = $request->score;
        $entry->save();
    }
    return response()->json(["success" => "match added"], 204);
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
