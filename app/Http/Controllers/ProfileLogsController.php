<?php

namespace App\Http\Controllers;

use App\Bundy\Response\ProfileTimeLogs;
use App\Bundy\Response\ProfileTimeLogDetails;

class ProfileLogsController extends Controller
{
    public function index()
    {
        return new ProfileTimeLogs();
    }

    public function show($date)
    {
        return new ProfileTimeLogDetails($date);
    }
}
