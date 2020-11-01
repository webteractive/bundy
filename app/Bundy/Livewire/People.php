<?php

namespace App\Bundy\Livewire;

use App\User;
use Livewire\Component;

class People extends Component
{
    public $search;
    
    public function getPeopleProperty()
    {
        return User::query()
                    ->employees()
                    ->active()
                    ->when($this->search, function($query, $search) {
                        return $query->where('first_name', 'LIKE', "%{$search}%") 
                                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                                    ->orWhere('alias', 'LIKE', "%{$search}%")
                                    ->orWhere('username', 'LIKE', "%{$search}%");
                    })
                    ->orderBy('last_name')
                    ->get();
    }

    public function render()
    {
        return view('bundy.livewire.people')
                    ->layout('bundy.layouts.auth');
    }
}
