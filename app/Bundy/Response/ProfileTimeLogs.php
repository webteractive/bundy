<?php 

namespace App\Bundy\Response;

use App\User;
use App\TimeLog;
use App\Bundy\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Responsable;

class ProfileTimeLogs implements Responsable
{
  protected $user;

  public function __construct($userId) {
    $this->user = User::find($userId);
  }

  public function toResponse($request)
  {
    $logs = TimeLog::query()
              ->with('user')
              ->addSelect(DB::raw('*'))
              ->addSelect(DB::raw('DATE(started_at) as date'))
              ->of($this->user)
              ->oldest('started_at')
              ->get()
              ->unique('date')
              ->values();

    return (new Paginator($logs))
              ->withUrl($request->url())
              ->toJson();
  }
}