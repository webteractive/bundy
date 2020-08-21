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
        $this->date = is_null($date) ? now()->modify('-1 day')->toDateString() : $date;
    }

    public function carbonize($dateStr)
    {
        return Carbon::createFromFormat('Y-m-d', $dateStr);
    }

    public function next()
    {
        $this->date = $this->carbonize($this->date)->modify('+1 day')->toDateString();
    }

    public function previous()
    {
        $this->date = $this->carbonize($this->date)->modify('-1 day')->toDateString();
    }

    public function getTitleProperty()
    {
        return 'Today';
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
