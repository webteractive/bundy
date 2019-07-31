<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bundy\Response\Performance;

class PerformanceController extends Controller
{
    public function __invoke()
    {
        return new Performance();
    }
}
