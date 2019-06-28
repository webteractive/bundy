<?php

namespace App\Events;

use App\ScheduleRequest;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class NewChangeScheduleRequest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ScheduleRequest $request)
    {
        $this->request = $request;
    }
}
