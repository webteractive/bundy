<?php

namespace App\Bundy;

use App\Timelog;
use Illuminate\Foundation\Inspiring;
use Illuminate\Contracts\Support\Responsable;

class Stream implements Responsable
{

  protected $items;

  public function __construct() {
    $this->items = collect([]);
  }

  public function toResponse($request)
  {
    return $this->addQuoteOfTheDay()
                ->addTimeLogs()
                ->items;
  }

  protected function addQuoteOfTheDay()
  {
    [$message, $author] = explode(' - ', Inspiring::quote());

    $this->items->push([
      'type' => 'quote',
      'message' => $message,
      'user' => [
        'name' => $author,
        'username' => null
      ]
    ]);

    return $this;
  }

  public function addTimeLogs()
  {
    $timelogs = Timelog::with('user')
                        // ->whereDate('started_at', now()->toDateString())
                        // ->groupBy('user_id')
                        ->oldest()
                        ->get()
                        ->toArray();
    $this->items = $this->items->concat($timelogs);
    return $this;
  }
}
