<?php
namespace App\Bundy\Response;

use App\User;
use App\TimeLog;
use Illuminate\Contracts\Support\Responsable;

class Performance implements Responsable
{
  public function toResponse($request)
  {
    return response()->json([
      'users' => $this->getUsers(),
      'timeLogs' => $this->getTimeLogs($request),
      'year' => now()->year
    ]);
  }

  protected function getUsers()
  {
    return User::query()
            ->employees()
            ->orderBy('last_name', 'ASC')
            ->get();
  }

  protected function getTimeLogs($request)
  {
    return TimeLog::query()
              ->with('schedule')
              ->whereYear('started_at', $request->query('year') ?? now()->year)
              ->whereMonth('started_at', $request->query('month') ?? now()->month)
              ->get();
  }
}