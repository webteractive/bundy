<?php

namespace App\Bundy\Livewire\Widgets;

use App\User;
use Livewire\Component;

class Birthdays extends Component
{
    public function getCelebrantsProperty()
    {
        return User::query()
                    ->whereDay('dob', now()->day)
                    ->whereMonth('dob', now()->month)
                    ->get();
    }

    public function getGreetingsProperty()
    {
        return collect([
            'You just lost one more year of your life. Happy birthday!',
            'Happy birthday, Dinosaur!',
            '<Greeting placeholder here>, Happy birthday!',
            'The secret to staying young is to live honestly, eat slowly, and lie about your age.',
            'May your day be more beautiful than a unicorn farting rainbows!'
        ])->random();
    }

    public function render()
    {
        return view('bundy.livewire.widgets.birthdays');
    }
}
