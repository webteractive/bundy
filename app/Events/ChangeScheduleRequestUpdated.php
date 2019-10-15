<?php

namespace App\Events;

use App\ScheduleRequest;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ChangeScheduleRequestUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $scheduleRequest;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ScheduleRequest $scheduleRequest)
    {
        $this->scheduleRequest = $scheduleRequest;
    }
}
