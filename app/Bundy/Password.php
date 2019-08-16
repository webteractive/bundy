<?php

namespace App\Bundy;

use Illuminate\Support\Str;
use App\Events\PasswordChanged;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Password
{
  protected $user;

  protected $reLogin = false;

  protected $logoutOtherDevices = false;

  public function of($user)
  {
    $this->user = $user;
    return $this;
  }

  public function logoutOtherDevices($logoutOtherDevices)
  {
    $this->logoutOtherDevices = $logoutOtherDevices;
    return $this;
  }

  public function reLogin($reLogin)
  {
    $this->reLogin = $reLogin;
    return $this;
  }

  public function change($password)
  {
    DB::transaction(function () use ($password) {
      $this->user->update([
        'password' => bcrypt($password)
      ]);

      event(new PasswordChanged($this->user, $password));

      if ($this->logoutOtherDevices) {
        auth()->logoutOtherDevices($password);
      }

      if ($this->reLogin) {
        auth()->logout();
      }
    });
    
    return response()->successful([
      'message' => __('messages.password.changed')
    ]);
  }

  public function reset($id)
  {
    DB::transaction(function () use ($id) {
      $password = Str::random(16);
      $this->user = tap(User::find($id), function($user) use ($password) {
        $user->update([
          'password' => bcrypt($password)
        ]);
      });

      event(new PasswordChanged($this->user, $password, true));
    });

    return response()->successful([
      'message' => __('messages.password.reset', ['name' => $this->user->name])
    ]);
  }
}