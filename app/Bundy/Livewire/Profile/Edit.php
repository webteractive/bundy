<?php

namespace App\Bundy\Livewire\Profile;

use Livewire\Component;

class Edit extends Component
{
    public function render()
    {
        return view('bundy.livewire.profile.edit')
                    ->layout('bundy.layouts.auth');
    }
}
