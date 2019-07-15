<?php

namespace App\Bundy;

use App\User;
use App\TimeLog as Model;
use Illuminate\Support\Facades\DB;

class TimeLogger {

  protected $user;

  protected $model;

  public function __construct(Model $model) {
    $this->model = $model;
  }

  public function log(User $user)
  {
    $this->user = $user;
    return $this;
  }

  public function start()
  {
    $this->model->create([
      'started_at' => now(),
      'user_id' => $this->user->id,
      'schedule_id' => optional($this->getTodaysSchedule())->id
    ]);

    if ($this->user->is_not_admin && config('app.enable_fence')) {
      (new Fence(request()->ip()))
        ->withUser($this->user)
        ->logAccess();
    }
  }

  public function getTodaysSchedule()
  {
    return $this->user->schedules->where('details.day', now()->dayOfWeek)->first();
  }

  public function stop()
  {
    $timeLog = $this->model->where('user_id', $this->user->id)->latest()->first();

    if ($timeLog) {
        $timeLog->fill(['ended_at' => now()])->save();
    }
  }

  public function store($user)
  {
    DB::transaction(function () use ($user) {
      $this->log($user)->start();
    });
    
    return response()->successful([
      'user' => auth()->user()->fresh()
    ]);
  }
}