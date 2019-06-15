<?php

namespace App\Bundy;

use App\TimeLog;
use Illuminate\Contracts\Support\Responsable;

class Presence implements Responsable 
{
  public function toResponse($request)
  {
    $present = TimeLog::query()
                ->with('user')
                ->whereDate('started_at', now()->toDateString())
                ->oldest('started_at')
                ->get()
                ->unique('user_id')
                ->values()
                ->all();

    return response()->json($present);
  }
}