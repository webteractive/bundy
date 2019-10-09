<?php

namespace App\Http\Controllers;

use App\Bundy\App;

class LoginController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect('/');
        }

        return new App('login');
    }
}
