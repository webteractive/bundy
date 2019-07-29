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
    if ($this->user->isNotAdmin()) {
      if ($this->model->of($this->user)->today()->get()->isEmpty()) {
        $this->model->create([
          'started_at' => now(),
          'user_id' => $this->user->id,
          'schedule_id' => optional($this->getTodaysSchedule())->id
        ]);
      } else {
        $this->model->of($this->user)->today()->first()->touch();
      }
    }

    if ($this->user->isNotAdmin() && config('app.enable_fence')) {
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
    if ($this->user->isNotAdmin()) {
      $timeLog = $this->model->query()
                            ->of($this->user)
                            ->today()
                            ->first();

      if ($timeLog) {
          $timeLog->fill(['ended_at' => now()])->save();
      }
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