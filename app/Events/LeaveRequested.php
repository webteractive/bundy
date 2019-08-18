<?php

namespace App\Events;

use App\Leave;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class LeaveRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $leave;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Leave $leave)
    {
        $this->leave = $leave;
    }
}
