<?php

namespace App\Bundy;

use Illuminate\Support\Facades\DB;

class Scheduler
{
  protected $days = [
    'monday' => 1,
    'tuesday' => 2,
    'wednesday' => 3,
    'thursday' => 4,
    'friday' => 5,
    'saturday' => 6
  ];

  public function save($schedules)
  {
    DB::transaction(function () use ($schedules) {
      tap(auth()->user(), function($user) use ($schedules) {
        $user->fill(['scheduled' => true])->save();
        $user->schedules()->detach();
        foreach ($schedules as $day => $schedule) {
          $user->schedules()->attach($schedule, [
            'day' => $this->days[$day]
          ]);
        }
      });
    });

    return response()->successful([
      'user' => auth()->user()->fresh()
    ]);
  }
}
