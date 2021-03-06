<?php

namespace App\Bundy;

use Illuminate\Support\Facades\DB;

class ProfileManager
{
  protected $model;

  public function __construct() {
    $this->model = auth()->user();
  }

  public function update($data)
  {
    DB::transaction(function () use ($data) {
      logger()->info('update', $data);
      $this->model->update($data);
    });

    return response()->successful([
      'user' => $this->model->fresh(),
      'message' => __('messages.profile.updated')
    ]);
  }
}
