<?php

namespace App\Bundy\Fence\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class NewDeviceLoggedIn
{
    use Dispatchable, SerializesModels;

    public $user;

    public $identity;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $identity)
    {
        $this->user = $user;
        $this->identity = $identity;
    }
}
