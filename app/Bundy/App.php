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
                'identifier' => $this->identifier,
                'qs' => $request->all() ?: null
              ],
              'ip' => $request->ip(),
              'user' => auth()->user(),
              'pages' => config('app.pages'),
              'profile' => $this->resolveProfile(),
              'schedules' => $this->getSchedules(),
              'quote' => $this->getQuoteOfTheDay(),
              'workingRemote' => (new Fence($request->ip()))->check(),
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
}
