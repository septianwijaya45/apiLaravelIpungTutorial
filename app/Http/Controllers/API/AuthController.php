<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function register(Request $request){
        $validateData = $request->validate([
            'name'      => 'required|max:55',
            'email'     => 'email|required|unique:users',
            'password'  => 'required|confirmed'
        ]);  

        $validateData['password'] = Hash::make($request->password);

        $user = User::create($validateData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([
            'user'      => $user,
            'token'     => $accessToken,
        ], 201);
    }

    function login (Request $request){
        $loginData = $request->validate([
            'email'     => 'email|required',
            'password'  => 'required'
        ]);

        if(!auth()->attempt($loginData)){
            return response([
                'message'       => 'User Not Found!'
            ], 400);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response([
            'user'      => auth()->user(),
            'token'     => $accessToken,
        ], 201);
    }
}
