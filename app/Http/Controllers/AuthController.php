<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponses;

    public function register(Request $request) {}

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error(["Invalid Credentials"]);
        }

        $user = User::firstWhere('email', $request->email);

        return $this->ok(
            'authenticated',
            [
                'token' => $user->createToken($user->email)->plainTextToken
            ]
        );
    }

    public function logout(Request $request) {}
}
