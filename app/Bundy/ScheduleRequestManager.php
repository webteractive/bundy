<?php

namespace App\Bundy;

use App\ScheduleRequest;
use Illuminate\Support\Facades\DB;
use App\Events\ChangeScheduleRequestUpdated;

class ScheduleRequestManager
{
  protected $model;

  protected $days = [
    'sunday' => 0,
    'monday' => 1,
    'tuesday' => 2,
    'wednesday' => 3,
    'thursday' => 4,
    'friday' => 5,
    'saturday' => 6
  ];

  public function __construct(ScheduleRequest $model) {
    $this->model = $model;
  }

  public function approve($id)
  {
    DB::transaction(function () use ($id) {
      $request = tap($this->model->find($id), function($request) {

        $request->user->schedules()->detach();

        foreach ($request->to as $day => $schedule) {
          $request->user->schedules()->attach($schedule, [
            'day' => $this->days[$day]
          ]);
        }

        $request->update(['approved' => 1]);
      });

      event(new ChangeScheduleRequestUpdated($request));
    });

    return response()->successful([
      'user' => auth()->user()->fresh(),
      'message' => __('messages.schedule.approved')
    ]);
  }

  public function decline($id, $reason = NULL)
  {
    DB::transaction(function () use ($id, $reason) {
      $request = tap($this->model->find($id), function($request) use ($reason) {
        $request->update([
          'approved' => 0,
          'action_reason' => $reason
        ]);
      });

      event(new ChangeScheduleRequestUpdated($request));
    });

    return response()->successful([
      'user' => auth()->user()->fresh(),
      'message' => __('messages.schedule.declined')
    ]);
  }
}
