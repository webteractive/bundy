<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $authenticated = auth()->viaRemember() || auth()->attempt($credentials, $request->remember);
        return response()->successful($authenticated, [
            'user' => auth()->user()
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->successful();
    }
}
