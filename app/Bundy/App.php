<?php

namespace App\Bundy;

use App\Schedule;
use Illuminate\Contracts\Support\Responsable;

class App implements Responsable
{
  public function toResponse($request)
  {
    return view('welcome')
            ->withPayload([
              'ip' => $request->ip(),
              'user' => auth()->user(),
              'schedules' => $this->getSchedules(),
              'apis' => $this->getApis()
            ]);
  }

  public function getSchedules()
  {
    return Schedule::all();
  }

  public function getApis()
  {
    return [
      'home' => route('home'),
      'login' => route('login'),
      'logout' => route('logout'),
      'schedules' => [
        'update' => route('schedules.update')
      ]
    ];
  }
}
