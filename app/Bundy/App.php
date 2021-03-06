<?php

namespace App\Bundy;

use App\User;
use App\Role;
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
    return view('welcome', [
      'payload' => [
        'request' => [
          'page' => $this->page,
          'inner' => $this->inner,
          'identifier' => $this->identifier,
          'qs' => $request->all() ?: null
        ],
        'roles' => Role::all(),
        'ip' => $request->ip(),
        'user' => auth()->user(),
        'pages' => config('app.pages'),
        'profile' => $this->resolveProfile(),
        'schedules' => $this->getSchedules(),
        'quote' => $this->getQuoteOfTheDay(),
        'birthdayCelebrant' => $this->getBirthdayCelebrant(),
        'workingRemote' => (new Fence($request->ip()))->check(),
      ]
    ]);
  }

  public function getQuoteOfTheDay()
  {
    return Cache::remember('quoteOfTheDay', 7200, function () {
        return Inspiring::quote();
    });
  }

  public function getSchedules()
  {
    return Cache::remember('schedules', 7200, function () {
      return Schedule::all();
    });
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

  public function getBirthdayCelebrant()
  {
    return User::whereMonth('dob', now()->month)
                ->whereDay('dob', now()->day)
                ->first();
  }
}
