<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    //
    public function register(Request $request){
        // dd($request);
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400); // Return validation errors with a 400 status code
        }

        User::create(
            ['name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email]);
        
        return response()->json(['message' => 'success'], 201);
    }

    public function login (Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string']]);
            // dd($request);
        
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }
        if(!Hash::check($request->password, User::where('email', $request->email)->first('password')->password)){
            return response()->json(['errors' => 'invalid credentials']);
        }
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth_token');
        return response()->json(['token' => $token->plainTextToken], 200);
    }

    public function logout(Request $request){
        // dd($request);
        try{
            $request->user()->currentAccessToken()->delete();
        }
        catch (Exception $e){
            return response()->json(["message" => "error"], 500);
        }
        return response()->json(['message' => "token destroyed"], 200);
    }
    
    public function getinfos(Request $request){
        // dd("law");

        $user = $request->user();

        return response()->json(['name' => $user->name, 'email' => $user->email], 200);
    }
}
