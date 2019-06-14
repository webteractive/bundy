<?php

namespace App\Bundy;

use App\TimeLog as Model;

class TimeLog
{

  protected $model;

  public function __construct(Model $model) {
    $this->model = $model;
  }

  public function items()
  {
    return $this->model->with('user')
                      ->whereDate('started_at', now()->toDateString())
                      ->get();
  }

}
