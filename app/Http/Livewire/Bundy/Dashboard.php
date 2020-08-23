<?php

namespace App\Http\Livewire\Bundy;

use App\Scrum;
use App\TimeLog;
use Livewire\Component;
use Illuminate\Support\Carbon;

class Dashboard extends Component
{
    public $date;

    public function mount($date = null)
    {
        $this->date = is_null($date) ? now()->toDateString() : $date;
    }

    public function carbonize($dateStr)
    {
        return Carbon::createFromFormat('Y-m-d', $dateStr);
    }

    public function next()
    {
        $this->date = $this->dateInCarbon()->modify('+1 day')->toDateString();
    }

    public function today()
    {
        $this->date = now()->toDateString();
    }

    public function previous()
    {
        $this->date = $this->dateInCarbon()->modify('-1 day')->toDateString();
    }

    public function getTitleProperty()
    {
        $date = $this->dateInCarbon();

        return $date->isToday()
                    ? $date->format('l') . ', ' . __('Today')
                    : $date->format('l, M d, Y');
    }

    public function getDateInCarbonProperty()
    {
        return $this->dateInCarbon();
    }

    public function dateInCarbon()
    {
        return $this->carbonize($this->date);
    }

    public function getStreamsProperty()
    {
        $streams = collect([]);
        $date = $this->carbonize($this->date);

        $logs = TimeLog::query()
                    ->with('user', 'schedule')
                    ->whereDate('started_at', $date->toDateString())
                    ->oldest('started_at')
                    ->get()
                    ->unique('user_id')
                    ->all();

        $scrum = Scrum::query()
                    ->with('user')
                    ->whereDate('created_at', $date->toDateString())
                    ->get();

        return $streams->concat($logs)
                    ->concat($scrum)
                    ->sortByDesc(function($item) {
                        return strtotime($item->stream_date);
                    })
                    ->values()
                    ->all();
    }

    public function render()
    {
        return view('livewire.bundy.dashboard');
    }
}
