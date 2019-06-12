<?php

namespace App\Bundy;

use App\User;

class Employees
{
  protected $model;

  public function __construct(User $model) {
    $this->model = $model;
  }

  public function list()
  {
    return response()->successful([
      'employees' => $this->model->where('id', '<>', auth()->user()->id)->get()
    ]);
  }
}
