<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\StoreUserRequest;
use App\User;

class RegisterController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $user = User::create(array_merge(
            $request->only('name', 'email'),
            ['password' => bcrypt($request->password)],
            ['role_id' => 2]
        ));
    }
}
