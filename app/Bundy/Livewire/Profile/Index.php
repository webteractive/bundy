<?php

namespace App\Bundy\Livewire\Profile;

use App\User;
use Livewire\Component;

class Index extends Component
{
    public $tab = '';
    public $username;

    protected $queryString = [
        'tab' => ['except' => '']
    ];

    public function getProfileProperty()
    {
        return User::query()
                    ->whereUsername($this->username)
                    ->first();
    }

    public function getTabsProperty()
    {
        $tabs = [
            '' => 'Stream',
            'leaves' => 'Leaves',            
        ];

        $canViewPerformance = optional(auth()->user())->isAdmin()
                                || $this->getProfileProperty()->is(auth()->user());

        if ($canViewPerformance) {
            $tabs = array_merge($tabs, [
                'performance' => 'Perf',
            ]);
        }

        return $tabs;
    }

    public function mount($username, $tab = null)
    {
        // 404 if supplied tabs is non-existent
        if (! empty($tab)) {
            abort_if(! in_array($tab, array_keys($this->getTabsProperty())), 404);
        }

        $this->tab = $tab ?? '';
        $this->username = $username;
    }

    public function switchTab($username, $tab)
    {
        $this->tab = $tab;
        $this->username = $username;
    }
    
    public function render()
    {
        return view('bundy.livewire.profile.index');
    }
}
