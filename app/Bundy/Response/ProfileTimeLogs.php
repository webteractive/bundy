<?php 

namespace App\Bundy\Response;

use App\TimeLog;
use App\Bundy\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Responsable;

class ProfileTimeLogs implements Responsable
{
  public function toResponse($request)
  {
    $logs = TimeLog::query()
              ->with('user')
              ->addSelect(DB::raw('*'))
              ->addSelect(DB::raw('DATE(started_at) as date'))
              ->of($request->user())
              ->oldest('started_at')
              ->get()
              ->unique('date')
              ->values();

    return (new Paginator($logs))
              ->withUrl($request->url())
              ->toJson();
  }
}