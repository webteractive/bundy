<?php

namespace App\Http\Controllers;

use App\Bundy\Response\ProfileWall;

class ProfileWallController extends Controller
{
    /**
     * Handle the incoming request.
     * 
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return ProfileWall();
    }
}
