<?php

namespace App\Http\Controllers;

use App\Bundy\Stream;

class StreamController extends Controller
{
    public function __invoke()
    {
        return new Stream();
    }
}
