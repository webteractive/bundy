<?php

namespace App\Bundy;

use App\Leave;
use Illuminate\Support\Facades\DB;

class LeaveManager
{
  protected $user;

  public function for($user)
  {
    $this->user = $user;
    return $this;
  }

  public function request($payload)
  {
    DB::transaction(function () use ($payload) {
      [ $startsOn, $endsOn ] = $this->getDateRange($payload['dates']);
      Leave::create([
        'starts_on' => $startsOn,
        'ends_on' => $endsOn,
        'description' => $payload['description'],
        'user_id' => $this->user->id
      ]);
    });

    return response()->successful([
      'message' => __('messages.leave.requested')
    ]);
  }

  public function getDateRange($dates)
  {
    return explode(' to ', $dates);
  }
}