<?php

namespace App\Http\Livewire\Bundy;

use Livewire\Component;
use Livewire\WithPagination;

class Notification extends Component
{    
    public function getNotificationsProperty()
    {
        return auth()->user()->notifications;
    }

    public function render()
    {
        return view('livewire.bundy.notification');
    }
}
