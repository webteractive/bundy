<?php

namespace App\Http\Controllers;

use App\Bundy\App;

class LoginController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect('home');
        }

        return new App('login');
    }
}
