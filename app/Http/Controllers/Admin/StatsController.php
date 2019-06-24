<?php

namespace App\Http\Controllers\Admin;

use App\Bundy\Response\Stats;
use App\Http\Controllers\Controller;

class StatsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return new Stats();
    }
}
