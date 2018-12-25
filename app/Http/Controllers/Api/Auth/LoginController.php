<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json([
                'token_type' => 'Bearer',
                'token' => Auth::user()->createToken(config('app.name'))->accessToken
            ], 200);
        }

        return response()->json([
            'message' => 'You cannot sign with those credentials',
            'errors' => 'Unauthorised'
        ], 401);
    }
}
