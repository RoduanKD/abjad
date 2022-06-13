<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $token = $request->user()->createToken('login');

        return [
            'message' => __('auth.welcome'),
            'data'    => [
                'token' => $token->plainTextToken,
            ],
        ];
    }
}
