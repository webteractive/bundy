<?php

namespace App\Bundy;

use App\ScheduleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Events\ChangeScheduleRequested;
use App\Events\ChangeScheduleRequestUpdated;

class Scheduler
{
  protected $days = [
    'sunday' => 0,
    'monday' => 1,
    'tuesday' => 2,
    'wednesday' => 3,
    'thursday' => 4,
    'friday' => 5,
    'saturday' => 6
  ];

  public function store($schedules)
  {
    DB::transaction(function () use ($schedules) {
      tap(auth()->user(), function($user) use ($schedules) {
        $user->schedules()->detach();
        foreach ($schedules as $day => $schedule) {
          $user->schedules()->attach($schedule, [
            'day' => $this->days[$day]
          ]);
        }
      });
    });

    return response()->successful([
      'user' => auth()->user()->fresh(),
      'message' => __('messages.schedule.stored')
    ]);
  }

  public function requestChange($schedules)
  {
    DB::transaction(function () use ($schedules) {
      $request = ScheduleRequest::create([
        'from' => $this->getCurrentSchedulesAsField(),
        'to' => Arr::except($schedules, ['reason']),
        'reason' => $schedules['reason'],
        'user_id' => auth()->user()->id
      ]);

      event(new ChangeScheduleRequested($request));
    });
    
    return response()->successful([
      'message' => __('messages.schedule.requested')
    ]);
  }

  public function approvedRequest($requestId)
  {
    DB::transaction(function () use ($requestId) {
      $request = ScheduleRequest::find($requestId);

      $request->user->schedules()->detach();

      foreach ($request->to as $day => $schedule) {
        $request->user->schedules()->attach($schedule, [
          'day' => $this->days[$day]
        ]);
      }

      $request->approved = 1;
      $request->save();

      event(new ChangeScheduleRequestUpdated($request));
    });

    return response()->successful([
      'user' => auth()->user()->fresh(),
      'message' => __('messages.schedule.approved')
    ]);
  }

  protected function getCurrentSchedulesAsField()
  {
    $fields = [];
    
    foreach (auth()->user()->schedules as $schedule) {
      $fields = array_merge($fields, [
        array_keys($this->days)[$schedule->details->day] => $schedule->id
      ]);
    }

    return $fields;
  }
}
