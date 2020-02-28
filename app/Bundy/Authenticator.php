<?php

namespace App\Bundy;

use App\Bundy\Fence\LoginDevice;

class Authenticator
{

  public function login($request, $remember = false)
  {
    $authenticated = auth()->attempt($request->validate([
      'password' => 'required',
      'email' => 'email|required',
    ]), $remember);

    (new LoginDevice($request))->log();

    if ($authenticated) {
      return response()->successful([
        'user' => auth()->user()->fresh()
      ]);
    }

    return response()->json([
      'errors' => [
        'email' => ['Invalid email address or password'],
        'password' => ['Invalid email address or password'],
      ],
      'message' => __('auth.failed')
    ], 422);
  }

  public function logout()
  {
    auth()->logout();
    return response()->successful();
  }

  public function fresh()
  {
    return response()->json(auth()->user()->fresh() ?? null);
  }
}