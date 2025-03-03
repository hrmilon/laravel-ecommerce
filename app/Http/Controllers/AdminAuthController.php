<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    use ApiResponses;

    public function login(LoginRequest $request)
    {
        if (!Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            return $this->error(["Invalid Credentials"]);
        }

        $admin = Admin::firstWhere('email', $request->email);

        return $this->ok(
            'authenticated',
            [
                'token' => $admin->createToken($admin->email)->plainTextToken
            ]
        );
    }
}
