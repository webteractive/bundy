<?php 

namespace App\Bundy\Response;

use App\User;
use App\TimeLog;
use Illuminate\Contracts\Support\Responsable;

class ProfileTimeLogs implements Responsable
{
  protected $user;

  public function __construct($username) {
    $this->user = User::whereUsername($username)->first();
  }

  public function toResponse($request)
  {
    return response()->json($this->getLogs());
  }

  protected function getLogs()
  {
    return TimeLog::query()
              ->with('user', 'schedule')
              ->of($this->user)
              ->latest('started_at')
              ->paginate();
  }
}