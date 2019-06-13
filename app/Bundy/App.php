<?php

namespace App\Bundy;

use App\Schedule;
use App\Bundy\Employee;
use Illuminate\Foundation\Inspiring;
use Illuminate\Contracts\Support\Responsable;

class App implements Responsable
{
  protected $page;

  protected $identifier;

  public function __construct($page = null, $identifier = null) {
    $this->page = $page;
    $this->identifier = $identifier;
  }

  public function toResponse($request)
  {
    return view('welcome')
            ->withPayload([
              'request' => [
                'page' => $this->page,
                'identifier' => $this->identifier
              ],
              'profile' => $this->resolveProfile(),
              'ip' => $request->ip(),
              'user' => auth()->user(),
              'schedules' => $this->getSchedules(),
              'apis' => $this->getApis(),
              'quote' => Inspiring::quote()
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
      ],
      'logs' => [
        'store' => route('logs.store')
      ],
      'employee' => [
        'list' => route('employee.list'),
        'show' => route('employee.show')
      ]
    ];
  }

  public function resolveProfile()
  {
    if (is_null($this->page !== 'profile')) {
      return null;
    }
    
    if ($this->identifier !== auth()->user()->username) {
      return app(Employee::class)->lookup($this->identifier);
    }

    return auth()->user();
  }
}
