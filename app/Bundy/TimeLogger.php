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
    if ($this->user->schedules->isNotEmpty()) {
      $this->model->create([
        'started_at' => now(),
        'user_id' => $this->user->id,
        'schedule_id' => $this->getTodaysSchedule()->id
      ]);
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