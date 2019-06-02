<?php

namespace App\Http\Controllers;

use App\Bundy\App;

class BundyController extends Controller
{
    public function index()
    {
        return new App();
    }
}
