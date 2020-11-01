<?php

namespace App\Bundy\Livewire\Profile;

use App\Bundy\Toast;
use App\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $firstName;
    public $lastName;
    public $username;
    public $alias;
    public $bio;
    public $address;
    public $contactNumbers;
    public $links;

    public $photoFile;
    public $coverFile;


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

    public function getProfileProperty()
    {
        return User::find(auth()->id());
    }

    public function mount()
    {
        tap($this->getProfileProperty(), function($user) {
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
        
        tap($this->getProfileProperty(), function($user) use ($data) {
           $user->update($data);

           if ($this->photoFile) {
                $this->uploadMedia($user, $this->photoFile, 'photo');
           }

           if ($this->coverFile) {
                $this->uploadMedia($user, $this->coverFile, 'cover');
            }
        });

        Toast::flash('Changes to profile has been saved successfully.');
    }

    private function uploadMedia($user, $file, $collection)
    {
        $media = $user->addMediaFromString($file->get())
                    ->usingFileName($file->getClientOriginalName())
                    ->toMediaCollection($collection);

        $user->update([
            $collection => [
                'original' => $media->getUrl(),
                'small' => $media->getUrl('small'),
                'banner' => $media->getUrl('banner'),
                'smaller' => $media->getUrl('smaller'),
                'smallest' => $media->getUrl('smallest'),
            ]
        ]);
    }
    
    public function render()
    {
        return view('bundy.livewire.profile.edit')
                    ->layout('bundy.layouts.auth');
    }
}
