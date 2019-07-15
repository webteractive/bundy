<?php 

namespace App\Bundy\Response;

use App\TimeLog;
use App\Bundy\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Responsable;

class ProfileTimeLogDetails implements Responsable
{
  protected $user;

  protected $date;

  public function __construct($user, $date) {
    $this->date = $date;
    $this->user = $user;
  }

  public function toResponse($request)
  {
    $logs = TimeLog::query()
              ->with('user')
              ->where('user_id', $this->user)
              ->whereDate('started_at', $this->date)
              ->get();

    return response()->json($logs);
  }
}