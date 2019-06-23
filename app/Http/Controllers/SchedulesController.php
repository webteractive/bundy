<?php

namespace App\Http\Controllers;

use App\Bundy\Scheduler;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    /**
     * Store user schedules
     *
     * @param \App\Bundy\Scheduler $scheduler
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Scheduler $scheduler, Request $request)
    {
        return $scheduler->store($request->validate([
            'monday' => 'required',
            'tuesday' => 'required',
            'wednesday' => 'required',
            'thursday' => 'required',
            'friday' => 'required'
        ]));
    }

    /**
     * Request update user schedules
     *
     * @param \App\Bundy\Scheduler $scheduler
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Scheduler $scheduler, Request $request)
    {
        return $scheduler->requestChange($request->validate([
            'monday' => 'required',
            'tuesday' => 'required',
            'wednesday' => 'required',
            'thursday' => 'required',
            'friday' => 'required',
            'saturday' => 'required',
            'saturday' => 'required',
            'reason' => 'required',
        ]));
    }
}
