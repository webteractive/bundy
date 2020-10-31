<?php

namespace App\Bundy\Livewire\Profile;

use App\User;
use Livewire\Component;
use Illuminate\Support\Str;

class Edit extends Component
{
    public User $profile;

    public $firstName;
    public $lastName;
    public $username;
    public $alias;
    public $bio;
    public $address;
    public $contactNumbers;
    public $links;

    protected $rules = [
        'firstName' => 'required',
        'lastName' => 'required',
        'username' => 'required',
        'alias' => 'nullable',
        'bio' => 'nullable',
        'address' => 'nullable',
        'contactNumbers.*' => 'required',
        'links.*' => 'required|url',
    ];

    public function mount()
    {
        tap(User::find(auth()->id()), function($user) {
            $this->fill([
                'firstName' => $user->first_name,
                'lastName' => $user->last_name,
                'username' => $user->username,
                'alias' => $user->alias,
                'bio' => $user->bio,
                'address' => $user->address,
                'contactNumbers' => $user->contact_numbers ?? [],
                'links' => $user->links ?? [],
            ]);
        });
    }

    public function appendTo($field, $value)
    {
        if (! empty($value)) {
            $this->{$field}[] = $value;
        }
    }

    public function removeFrom($field, $index)
    {
        $values = $this->{$field};
        unset($values[$index]);
        $this->{$field} = array_values($values);
    }

    public function save()
    {
        $data = collect($this->validate())
                    ->mapWithKeys(function ($item, $key) {
                        return [Str::snake($key) => $item];
                    })
                    ->all();
        
        tap(User::find(auth()->id()), function($user) use ($data) {
           $user->update($data);
        });
    }
    
    public function render()
    {
        return view('bundy.livewire.profile.edit')
                    ->layout('bundy.layouts.auth');
    }
}
