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
    $stream = $this->addQuoteOfTheDay($request)
                  ->appendTimeLogs($request)
                  ->appendScrums($request)
                  ->items
                  ->sortByDesc(function($item) {
                    return strtotime($item->stream_date);
                  })
                  ->values()
                  ->all();

    return response()->json($stream);
  }

  protected function addQuoteOfTheDay($request)
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
      'stream_date' => $this->getFilterDate($request)->setTime(0, 0, 0)->toDateTimeString()
    ]);

    return $this;
  }

  public function appendTimeLogs($request)
  {
    $timeLogs = TimeLog::query()
                  ->with('user')
                  ->whereDate('started_at', $this->getFilterDate($request)->toDateString())
                  ->oldest('started_at')
                  ->get()
                  ->unique('user_id')
                  ->all();
    return $this->concat($timeLogs);
  }

  protected function appendScrums($request)
  {
    $entries = Scrum::query()
                ->with('user')
                ->whereDate('created_at', $this->getFilterDate($request)->toDateString())
                ->get();

    return $this->concat($entries);
  }

  protected function getFilterDate($request)
  {
    if ($request->has('date')) {
      [$year, $day, $month] = explode('-', $request->date);
      return now()->setDate($year, $month, $day);
    }
    
    return now();
  }

  public function concat($items)
  {
    $this->items = $this->items->concat($items);
    return $this;
  }
}
