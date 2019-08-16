<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class PasswordChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $password;

    public $viaReset = false;

    public function __construct($user, $password, $viaReset = false)
    {
        $this->user = $user;
        $this->password = $password;
        $this->viaReset = $viaReset;
    }
}
