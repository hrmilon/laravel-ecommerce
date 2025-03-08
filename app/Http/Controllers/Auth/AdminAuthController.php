<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    use ApiResponses;

    public function login(LoginRequest $request)
    {
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return $this->error(['Invalid Credentials'], 401);
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
