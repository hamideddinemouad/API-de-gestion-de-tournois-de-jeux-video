<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\api\MatcheController;
use App\Http\Controllers\api\PlayerController;
use App\Http\Controllers\API\TournamentController;
use App\Http\Controllers\api\TournamentPlayerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function(){
    return 'wow';
});

// Route::get('login', function(){
//     return response()->json(['message' => 'Login']);
// });
// Route::resource('users',)
Route::post('register', [AuthController::class,'register']);

Route::post('login', [AuthController::class,'login']);

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('userinfos', [AuthController::class, 'getinfos'])->middleware('auth:sanctum');

Route::post('tournaments', [TournamentController::class, 'store'])->middleware('auth:sanctum');

Route::get('tournaments/{id}',[TournamentController::class, 'show']) ->middleware('auth:sanctum');

Route::put('tournaments/{id}', [TournamentController::class, 'update'])->middleware('auth:sanctum');

Route::delete('tournaments/{id}', [TournamentController::class, 'destroy'])->middleware('auth:sanctum');

Route::post('players/new', [PlayerController::class, 'store']);

Route::post('tournaments/{TournamentId}/players', [TournamentPlayerController::class, 'store']);
// [GET] /api/tournaments/{tournament\_id}/players
Route::get('tournaments/{TournamentId}/players',[TournamentPlayerController::class, 'show']);


// [DELETE] /api/tournaments/{tournament\_id}/players/{player\_id}

Route::delete('tournaments/{tournamentId}/players/{playerId}', [TournamentPlayerController::class, 'destroy']);

Route::post('matches', [MatcheController::class, 'store']);





