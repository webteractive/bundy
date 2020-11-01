<?php

namespace App\Bundy\Livewire\Widgets;

use App\TimeLog;
use Livewire\Component;

class Presence extends Component
{
    public function getPresentProperty()
    {
        return TimeLog::query()
                    ->with('user')
                    ->today()
                    ->get();
    }
    
    public function render()
    {
        return view('bundy.livewire.widgets.presence');
    }
}
