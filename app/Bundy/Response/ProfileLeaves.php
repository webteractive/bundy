<?php

namespace App\Bundy\Response;

use App\User;
use Illuminate\Contracts\Support\Responsable;

class ProfileLeaves implements Responsable
{
  public function toResponse($request)
  {
    return response()->json(
      User::query()
        ->whereUsername($request->username)
        ->first()
        ->leaves()
        ->with('user')
        ->oldest('starts_on')
        ->upcoming()
        ->paginate(
          config('app.leave.slots')
        )
    );
  }
}