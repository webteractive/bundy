<?php

namespace App\Bundy\Response;

use App\User;
use App\Leave;
use Illuminate\Contracts\Support\Responsable;

class Leaves implements Responsable
{
  protected $viaProfile;

  public function __construct($viaProfile = true) {
    $this->viaProfile = $viaProfile;
  }

  public function toResponse($request)
  {
    return response()->json(
      $this->source($request)
        ->with('user')
        ->oldest('starts_on')
        ->upcoming()
        ->paginate(config('app.leave.slots'))
    );
  }

  public function source($request)
  {
    if ($this->viaProfile) {
      return User::query()
              ->whereUsername($request->username)
              ->first()
              ->leaves();
    }

    return Leave::query();
  }
}