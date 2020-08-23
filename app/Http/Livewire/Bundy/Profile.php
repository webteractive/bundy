<?php

namespace App\Http\Livewire\Bundy;

use App\User;
use Livewire\Component;

class Profile extends Component
{
    protected $username;

    public function mount($username = null)
    {
        $this->username = $username;
    }

    public function getProfileProperty()
    {
        return is_null($this->username)
                    ? auth()->user()
                    : User::findByUsername($this->username)->first();
    }

    public function render()
    {
        return view('livewire.bundy.profile');
    }
}
