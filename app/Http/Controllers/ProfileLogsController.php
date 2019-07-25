<?php

namespace App\Http\Controllers;

use App\Bundy\Response\ProfileTimeLogs;
use App\Bundy\Response\ProfileTimeLogDetails;

class ProfileLogsController extends Controller
{
    public function index($user)
    {
        return new ProfileTimeLogs($user);
    }

    public function show($user, $date)
    {
        return new ProfileTimeLogDetails($user, $date);
    }
}
