<?php

namespace App\Bundy\Livewire\Profile;

use App\User;
use Livewire\Component;

class Contents extends Component
{
    public $username;
    public $tab = 'stream';

    public function getTabsProperty()
    {
        $tabs = [
            'stream' => 'Stream',
            'leaves' => 'Leaves',            
        ];

        $canViewPerformance = optional(auth()->user())->isAdmin()
                                || $this->getProfileProperty()->is(auth()->user());

        if ($canViewPerformance) {
            $tabs = array_merge($tabs, [
                'performance' => 'Performance',
            ]);
        }

        return $tabs;
    }

    public function getProfileProperty()
    {
        return User::query()
                    ->where('username', $this->username)
                    ->first();
    }

    public function mount($username)
    {
        $this->username = $username;
    }

    public function switchTab($tab)
    {
        $this->tab = $tab;
    }

    public function render()
    {
        return view('bundy.livewire.profile.contents');
    }
}
