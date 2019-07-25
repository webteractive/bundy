<?php

namespace App\Bundy\Response;

use App\User;
use Illuminate\Contracts\Support\Responsable;

class UserList implements Responsable
{
  public function toResponse($request)
  {
    return response()->json(User::others()->paginate(10));
  }
}
