<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TournamentController extends Controller
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
        $validation = Validator::make($request->all(), [
            'description' => ['required', 'string'],
            'name' => ['required', 'string']
        ]);
        if ($validation->fails()){
            return response()->json(['error' => 'error occured'], 422);
        }
        Tournament::create(['description' => $request->description, 'name' => $request->name]);
        return response()->json(['success' => 'tournament created'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tournament = Tournament::find($id);
        if(!$tournament){
            return response()->json(['error' => 'no tournament with that id'], 404);
        }
        return response()->json(['name:' => $tournament->name, 'description:' => $tournament->description], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validation = Validator::make($request->all(), [
            'name' => ['string', 'required'],
            'description' => ['string', 'required']]);
        
        $tournament = Tournament::find($id);

    if ($validation->fails() || !$tournament){
        return response()->json(['error' => 'error occured'], 422);
    }

    $tournament->name = $request->name;
    $tournament->description = $request->description;
    $tournament->save();
    return response()->json(['success' => 'Updated successfully'], 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $tournament = Tournament::find($id);
        if(!$tournament){
            return response()->json(["error" => "no Tournament with this id"], 404);
        }
        $tournament->delete();
        return response()->noContent();
    }
}
