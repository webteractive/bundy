<?php

namespace App\Bundy;

use App\User;

class Employee
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

  public function lookup($username)
  {
    return $this->model->whereUsername($username)->first();
  }

  public function details($username)
  {
    return response()->successful([
      'user' => $this->lookup($username)
    ]);
  }
}
