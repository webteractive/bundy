<?php

namespace App\Bundy;

use App\User;
use Illuminate\Support\Facades\Auth;
class Authenticator
{

    public function login($credentials)
    {
        $authenticated = Auth::attempt(array_merge($credentials, [
            'status' => User::STATUS_ACTIVE
        ]));

        if ($authenticated) {
            return response()->successful([
                'user' => Auth::user()
            ]);
        }

        return response()->json([
            'errors' => [
                'email' => ['Invalid email address or password'],
                'password' => ['Invalid email address or password'],
            ],
            'message' => __('auth.failed')
        ], 422);
    }

    public function logout()
    {
        Auth::logout();
        return response()->successful();
    }

    public function fresh()
    {
        return response()->json(Auth::user() ?? null);
    }
}
