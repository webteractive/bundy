<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Bundy\Response\ScheduleRequestsList;
use App\Bundy\Scheduler;

class ScheduleRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ScheduleRequestsList();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Bundy\Scheduler  $scheduler
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Scheduler $scheduler, $id = 0)
    {
        return $scheduler->approvedRequest($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
