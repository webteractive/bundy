<?php

namespace App\Bundy;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Password
{
  protected $user;

  public function of($user)
  {
    $this->user = $user;
    return $this;
  }

  public function change($password)
  {
    DB::transaction(function () use ($password) {
      $this->user->update([
        'password' => bcrypt($password)
      ]);
    });
    
    return response()->successful([
      'message' => __('messages.password.updated')
    ]);
  }

  public function reset(Type $var = null)
  {
    # code...
  }
}