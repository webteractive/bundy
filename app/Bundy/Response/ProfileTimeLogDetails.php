<?php 

namespace App\Bundy\Response;

use App\TimeLog;
use App\Bundy\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Responsable;

class ProfileTimeLogDetails implements Responsable
{
  protected $date;

  public function __construct($date) {
    $this->date = $date;
  }

  public function toResponse($request)
  {
    $logs = TimeLog::query()
              ->with('user')
              ->of($request->user())
              ->whereDate('started_at', $this->date)
              ->get();

    return response()->json($logs);
  }
}