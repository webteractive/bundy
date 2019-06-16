<?php

namespace App\Bundy;

class Authenticator {

  public function login($credentials, $remember = false)
  {
    $authenticated = auth()->viaRemember() || auth()->attempt($credentials, $remember);
    return response()->successfulOrFailed($authenticated, [
        'user' => auth()->user()->fresh()
    ]);
  }

  public function logout()
  {
    auth()->logout();
    return response()->successful();
  }

  public function fresh()
  {
    return response()->json(false);
    return response()->json(auth()->user()->fresh() ?? null);
  }
}