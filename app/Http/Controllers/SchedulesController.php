<?php

namespace App\Http\Controllers;

use App\Bundy\Scheduler;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    /**
     * Update user schedules
     *
     * @param \App\Bundy\Scheduler $scheduler
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Scheduler $scheduler, Request $request)
    {
        $schedules = $request->validate([
            'monday' => 'required',
            'tuesday' => 'required',
            'wednesday' => 'required',
            'thursday' => 'required',
            'friday' => 'required',
            'saturday' => 'required',
        ]);

        return $scheduler->save($schedules);
    }
}
