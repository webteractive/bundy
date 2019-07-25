<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bundy\Authenticator;
use App\Rules\EmailDomainRecognized;

class AuthenticationController extends Controller
{
    protected $authenticator;

    public function __construct(Authenticator $authenticator) {
        $this->authenticator = $authenticator;
    }

    public function login(Request $request)
    {
        return $this->authenticator->login($request->validate([
            'password' => 'required',
            'email' => 'email|required',
        ]), $request->remember);
    }

    public function logout()
    {
        return $this->authenticator->logout();
    }

    public function refresh()
    {
        return $this->authenticator->fresh();
    }
}
