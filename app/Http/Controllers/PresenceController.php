<?php

namespace App\Http\Controllers;

use App\Bundy\Presence;

class PresenceController extends Controller
{
    public function __invoke()
    {
        return new Presence();
    }
}
