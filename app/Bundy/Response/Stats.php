<?php

namespace App\Bundy\Response;

use App\ScheduleRequest;
use Illuminate\Contracts\Support\Responsable;

class Stats implements Responsable
{
  public function toResponse($request)
  {
    return response()->json([
      'scheduleRequests' => ScheduleRequest::pending()->count()
    ]);
  }
}
