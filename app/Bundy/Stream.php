<?php

namespace App\Bundy;

use App\TimeLog;
use Illuminate\Support\Str;
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
      'id' => (string) Str::uuid(),
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
    $timeLogs = TimeLog::with('user')->oldest('started_at')->get()->unique('user_id');

    $this->items = $this->items->concat($timeLogs->toArray());
    return $this;
  }
}
