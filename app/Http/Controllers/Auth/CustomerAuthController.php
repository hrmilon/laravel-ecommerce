<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Customer;
use App\Traits\ApiResponses;
use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    use ApiResponses;

    public function login(LoginRequest $request)
    {

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return $this->error(['Invalid Credentials'], 401);
        }

        // if (!Auth::guard('customer')->attempt($request->only('email', 'password'))) {
        //     return $this->error(["Invalid Credentials"]);
        // }

        $customer = Customer::firstWhere('email', $request->email);

        return $this->ok(
            'authenticated',
            [
                'token' => $customer->createToken($customer->email)->plainTextToken
            ]
        );
    }
}
