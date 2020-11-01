<?php

namespace App\Bundy\Livewire;

use App\Bundy\Toast;
use App\Scrum;
use App\TimeLog;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Foundation\Inspiring;

class Stream extends Component
{
    public $date;

    protected $listeners = [
        'scrummed' => 'reload'
    ];

    public function mount()
    {
        $this->today();
    }

    public function previous()
    {   
        $this->date = $this->date->subDay();
    }

    public function next()
    {   
        $this->date = $this->date->addDay();
    }

    public function today()
    {   
        $this->date = now();
    }

    public function reload($toast)
    {
        Toast::parseAndFlash($toast);
        $this->today();
    }

    public function getStreamTitleProperty()
    {
        if ($this->date->isToday()) {
           return __('Today, ') . $this->date->englishDayOfWeek;
        }

        return $this->date->format('l, M d, Y');
    }

    public function getStreamProperty()
    {
        $items = collect([]);

        $this->addQuoteOfTheDay($items)
            ->appendTimeLogs($items)
            ->appendScrums($items);

        return $items->sortByDesc(function($item) {
                    return strtotime($item->stream_date);
                })
                ->values();
    }

    protected function addQuoteOfTheDay(&$items)
    {
        [$message, $author] = explode(' - ', Inspiring::quote());

        $items->push((object) [
            'id' => (string) Str::uuid(),
            'message' => $message,
            'user' => (object) [
                'name' => $author,
                'username' => Str::slug($author),
            ],
            'stream_type' => 'quote',
            'stream_date' => $this->getFilterDate()->setTime(0, 0, 0)
        ]);

        return $this;
    }

    protected function appendScrums(&$items)
    {
        $entries = Scrum::query()
                        ->with('user')
                        ->whereDate('created_at', $this->getFilterDate()->toDateString())
                        ->get();

        $items = $items->concat($entries);

        return $this;
    }

    protected function appendTimeLogs(&$items)
    {
        $timeLogs = TimeLog::query()
                        ->with('user', 'schedule')
                        ->whereDate('started_at', $this->getFilterDate()->toDateString())
                        ->oldest('started_at')
                        ->get()
                        ->unique('user_id')
                        ->all();

        $items = $items->concat($timeLogs);
        
        return $this;
    }

    protected function getFilterDate()
    {
        if ($this->date) {
            [$year, $month, $day] = explode('-', $this->date);
            return now()->setDate($year, $month, $day);
        }
        
        return now();
    }

    public function render()
    {
        return view('bundy.livewire.stream');
    }
}
