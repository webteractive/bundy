<?php

namespace App\Http\Controllers;

use App\Bundy\App;

class BundyController extends Controller
{
    public function index($page = null, $identifier = null, $inner = null)
    {
        return new App($page, $identifier, $inner);
    }
}
