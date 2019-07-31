<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Bundy\ScheduleRequestManager;
use App\Bundy\Response\ScheduleRequestsList;

class ScheduleRequestsController extends Controller
{
    public function index()
    {
        return new ScheduleRequestsList();
    }

    public function update(ScheduleRequestManager $manager, $id)
    {
        return $manager->approve($id);
    }

    public function destroy(ScheduleRequestManager $manager, $id)
    {
        return $manager->decline($id);
    }
}
