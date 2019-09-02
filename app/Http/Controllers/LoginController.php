<?php

namespace App\Http\Controllers;

use App\Bundy\App;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->check()) {
            return redirect('home');
        }
        
        return new App('login');
    }
}
