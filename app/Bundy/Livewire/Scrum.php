<?php

namespace App\Bundy\Livewire;

use App\Scrum as Model;
use App\Bundy\Slack;
use App\Bundy\Toast;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Scrum extends Component
{
    public $yesterday = [];
    public $blockers = [];
    public $today = [];

    public $shown = false;

    protected $listeners = [
        'edit'
    ];

    protected $rules = [
        'today' => 'required',
        'today.*' => 'required'
    ];

    public function getNotYetProperty()
    {
        return Model::query()
                ->of(auth()->user())
                ->today()
                ->get()
                ->isEmpty();
    }

    public function getButtonLabelProperty()
    {
        return $this->getNotYetProperty()
                    ? 'Post Scrum'
                    : 'Save Changes';
    }

    public function getTodaysScrumProperty()
    {
        return Model::query()
                ->of(auth()->user())
                ->today()
                ->first();
    }

    public function mount()
    {
        $this->shown = $this->getNotYetProperty();
    }

    public function edit()
    {
        tap($this->getTodaysScrumProperty(), function($scrum) {
            $this->fill([
                'shown' => true,
                'yesterday' => $scrum->yesterday,
                'blockers' => $scrum->blockers,
                'today' => $scrum->today,
            ]);
        });
    }

    public function close()
    {
        $this->reset();
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
        $notYet = $this->getNotYetProperty();

        $this->validate();

        DB::transaction(function () {
            $user = auth()->user();
            $scrum = $this->getTodaysScrumProperty();
        
            $payload = [
                'yesterday' => $this->yesterday,
                'blockers' => $this->blockers,
                'today' => $this->today,
                'user_id' => $user->id
            ];
        
            if (is_null($scrum)) {
                $scrum = Model::create($payload);
            } else {
                $scrum->update($payload);
            }        
        
            $slackMethod = is_null($scrum->slack) 
                            ? 'postMessage'
                            : 'updateMessage';

            $scrum->update([
                'slack' => (new Slack)->{$slackMethod}($scrum, $user)
            ]);    
        });

        $toast = null;

        if ($notYet) {
            $this->close();
            $toast = Toast::make('Scrum posted successfully.');
        } else {
            Toast::flash('Changes to your scrum has been saved successfully.');
        }

        $this->emitTo('stream', 'scrummed', $toast);
    }

    public function render()
    {
        return view('bundy.livewire.scrum');
    }
}
