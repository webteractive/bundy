<?php

namespace App\Bundy\Response;

use Illuminate\Contracts\Support\Responsable;

class ProfileWall implements Responsable
{
  public function toResponse($request)
  {
    return response()->json([
      
    ]);
  }
}