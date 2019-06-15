<?php

namespace App\Bundy;

use App\Scrum;
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
    $stream = $this->addQuoteOfTheDay()
                  ->appendTimeLogs()
                  ->appendScrums()
                  ->items
                  ->sortByDesc(function($item) {
                    return strtotime($item->stream_date);
                  })
                  ->values()
                  ->all();

    return response()->json($stream);
  }

  protected function addQuoteOfTheDay()
  {
    [$message, $author] = explode(' - ', Inspiring::quote());

    $this->items->push((object) [
      'id' => (string) Str::uuid(),
      'message' => $message,
      'user' => [
        'name' => $author,
        'username' => null
      ],
      'stream_type' => 'quote',
      'stream_date' => now()->setTime(0, 0, 0)->toDateTimeString()
    ]);

    return $this;
  }

  public function appendTimeLogs()
  {
    $timeLogs = TimeLog::query()
                  ->with('user')
                  ->whereDate('started_at', now()->toDateString())
                  ->oldest('started_at')
                  ->get()
                  ->unique('user_id')
                  ->all();

    return $this->concat($timeLogs);
  }

  protected function appendScrums()
  {
    $entries = Scrum::query()
                ->with('user')
                ->whereDate('created_at', now()->toDateString())
                ->get();

    return $this->concat($entries);
  }

  public function concat($items)
  {
    $this->items = $this->items->concat($items);
    return $this;
  }
}
