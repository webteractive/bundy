<?php

namespace App\Bundy\Livewire;

use App\User;
use App\Scrum;
use App\TimeLog;
use App\Bundy\Toast;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Inspiring;

class Stream extends Component
{
    public $date;
    public $username;
    public $inTheProfilePage = false;

    protected $listeners = [
        'scrummed' => 'reload'
    ];

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

    public function getUserProperty()
    {
        return User::query()
                    ->where('username', $this->username)
                    ->first();
    }

    public function mount($username = null, $inTheProfilePage = false)
    {
        $this->username = $username;
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

    public function setDate($time)
    {
        $this->date = Carbon::createFromTimestamp($time);
    }

    public function reload($toast)
    {
        Toast::parseAndFlash($toast);
        $this->today();
    }

    protected function addQuoteOfTheDay(&$items)
    {
        if (! $this->getUserProperty()) {

            if ($this->getFilterDate()->isFuture()) {

                $quote = collect([
                    ['message' => 'Life can only be understood backwards; but it must be lived forwards.', 'author' => 'Søren Kierkegaard'],
                    ['message' => 'The future belongs to those who believe in the beauty of their dreams.', 'author' => 'Eleanor Roosevelt'],
                    ['message' => 'It\'s amazing how a little tomorrow can make up for a whole lot of yesterday.', 'author' => 'John Guare'],
                    ['message' => 'Knowing too much of your future is never a good thing.', 'author' => 'Rick Riordan'],
                    ['message' => 'If you want a picture of the future, imagine a boot stamping on a human face—for ever.', 'author' => 'George Orwell'],
                    ['message' => 'We swore an oath to protect the Time Stone...with our lives.', 'author' => 'Wong'],
                    ['message' => 'Try Me, Beyonce.', 'author' => 'Dr. Steven Strange'],
                    ['message' => 'Low-key, no pressure, just hang with me and my weather.', 'author' => 'Hayley Williams'],
                ])->random();

                $items->push((object) [
                    'id' => (string) Str::uuid(),
                    'message' => $quote['message'],
                    'user' => (object) [
                        'name' => $quote['author'],
                        'username' => Str::slug($quote['author']),
                    ],
                    'stream_type' => 'quote',
                    'stream_date' => $this->getFilterDate()->setTime(0, 0, 0)
                ]);
                
            } else {
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
            }
        }

        return $this;
    }

    protected function appendScrums(&$items)
    {
        $entries = Scrum::query()
                        ->with('user')
                        ->whereDate('created_at', $this->getFilterDate()->toDateString())
                        ->when($this->getUserProperty(), function($query, $user) {
                            return $query->where('user_id', $user->id);
                        })
                        ->get();

        $items = $items->concat($entries);

        return $this;
    }

    protected function appendTimeLogs(&$items)
    {
        $timeLogs = TimeLog::query()
                        ->with('user', 'schedule')
                        ->whereDate('started_at', $this->getFilterDate()->toDateString())
                        ->when($this->getUserProperty(), function($query, $user) {
                            return $query->where('user_id', $user->id);
                        })
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
