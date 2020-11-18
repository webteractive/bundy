<?php

namespace App\Bundy\Livewire\Admin;

use Livewire\Component;

class Index extends Component
{
    public $tab = 'users';

    public function getTabsProperty()
    {
        $tabs = [
            'users' => 'Users',
            'schedule' => 'Schedule',          
            'leaves' => 'Leave',          
        ];

        return $tabs;
    }

    public function render()
    {
        return view('bundy.livewire.admin.index');
    }
}
