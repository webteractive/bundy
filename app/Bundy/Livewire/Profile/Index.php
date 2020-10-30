<?php

namespace App\Bundy\Livewire\Profile;

use App\User;
use Livewire\Component;

class Index extends Component
{
    protected $username;

    public function mount($username)
    {
        $this->username = $username;
    }

    public function getProfileProperty()
    {
        return User::query()
                ->where('username', $this->username)
                ->first();
    }

    public function render()
    {
        return view('bundy.livewire.profile.index')
                    ->layout('bundy.layouts.auth');
    }
}
