<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Customer;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    use ApiResponses;

    public function login(LoginRequest $request)
    {
        if (!Auth::guard('customer')->attempt($request->only('email', 'password'))) {
            return $this->error(["Invalid Credentials"]);
        }

        $customer = Customer::firstWhere('email', $request->email);

        return $this->ok(
            'authenticated',
            [
                'token' => $customer->createToken($customer->email)->plainTextToken
            ]
        );
    }
}
