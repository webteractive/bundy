<?php

namespace App\Bundy;

class Authenticator {

  public function login($credentials)
  {
    $authenticated = auth()->attempt($credentials);
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