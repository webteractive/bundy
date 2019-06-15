<?php

namespace App\Bundy;

use App\Schedule;
use App\Bundy\Employee;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Support\Responsable;

class App implements Responsable
{
  protected $page;
  protected $inner;
  protected $identifier;

  public function __construct($page = null, $identifier = null, $inner = null) {
    $this->page = $page;
    $this->inner = $inner;
    $this->identifier = $identifier;
  }

  public function toResponse($request)
  {
    return view('welcome')
            ->withPayload([
              'request' => [
                'page' => $this->page,
                'inner' => $this->inner,
                'identifier' => $this->identifier
              ],
              'profile' => $this->resolveProfile(),
              'ip' => $request->ip(),
              'user' => auth()->user(),
              'schedules' => $this->getSchedules(),
              'apis' => $this->getApis(),
              'quote' => $this->getQuoteOfTheDay()
            ]);
  }

  public function getQuoteOfTheDay()
  {
    Cache::remember('quoteOfTheDay', 86400, function () {
        return Inspiring::quote();
    });
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
      'stream' => route('stream'),
      'presence' => route('presence'),
      'schedules' => [
        'update' => route('schedules.update')
      ],
      'logs' => [
        'list' => route('logs.list'),
        'store' => route('logs.store'),
      ],
      'employee' => [
        'list' => route('employee.list'),
        'show' => route('employee.show')
      ],
      'scrum' => [
        'store' => route('scrum.store'),
        'update' => route('scrum.update'),
      ]
    ];
  }

  public function resolveProfile()
  {
    if (is_null($this->page !== 'profile')) {
      return null;
    }

    if (auth()->check() === false) {
      return null;
    }
    
    
    if ($this->identifier !== auth()->user()->username) {
      return app(Employee::class)->lookup($this->identifier);
    }

    return auth()->user();
  }
}
