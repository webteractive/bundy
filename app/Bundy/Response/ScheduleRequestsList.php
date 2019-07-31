<?php

namespace App\Bundy\Response;

use App\ScheduleRequest;
use Illuminate\Contracts\Support\Responsable;

class ScheduleRequestsList implements Responsable
{
  public function toResponse($request)
  {
    return response()->json($this->getScheduleRequests($request));
  }

  public function getScheduleRequests($request)
  {
    return ScheduleRequest::query()
              ->pending()
              ->paginate();
  }
}