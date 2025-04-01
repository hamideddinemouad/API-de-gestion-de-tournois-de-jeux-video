<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    
    /**
     * given id it returns name.
     */
    static public function name(string $id)
    {
        $player = Player::find($id);
        if ($player){
            return $player->name;
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validation = Validator::make($request->all(), 
        ['playername' => ['required', 'string'], 'email' => ['required', 'email', 'unique:players']]);

        if($validation->fails()){
            return response()->json(['error', $validation->errors()], 404);
        }

        $newPlayer = new Player();
        $newPlayer->name = $request->playername;
        $newPlayer->email = $request->email;
        $newPlayer->save();
        return response()->json(['success', 'player added'], 201);
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
