<?php

namespace App\Bundy;

use App\Scrum;
use Illuminate\Support\Facades\DB;

class ScrumMaster
{
  protected $user;

  protected $model;

  public function __construct(Scrum $model) {
    $this->model = $model;
    $this->user = auth()->user();
  }

  public function store($data)
  {
    DB::transaction(function () use ($data) {

      $scrum = $this->model->of($this->user)->today()->first();
      
      $payload = array_merge($data, [
        'user_id' => $this->user->id
      ]);

      if (is_null($scrum)) {
        $scrum = $this->model->create($payload);
      }

      $scrum->fill($payload)->save();
    });

    return response()->successful([
      'user' => $this->user->fresh()
    ]);
  }

  public function update($id, $data)
  {
    DB::transaction(function () use ($id, $data) {
      $this->model->find($id)->fill($data)->save();
    });

    return response()->successful([
      'user' => $this->user->fresh()
    ]);
  }
}