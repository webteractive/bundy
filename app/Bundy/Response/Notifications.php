<?php

namespace App\Bundy\Response;

use Illuminate\Contracts\Support\Responsable;

class Notifications implements Responsable
{
  public function toResponse($request)
  {
    return response()->json($request->user()->notifications);
  }
}
