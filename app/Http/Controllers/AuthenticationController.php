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
            'email' => [
                'required',
                'email',
                new EmailDomainRecognized
            ],
            'password' => 'required'
        ]), $request->remember);
    }

    public function logout()
    {
        return $this->authenticator->logout();
    }
}
