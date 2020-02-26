<?php

namespace App\Listeners;

use App\Bundy\TimeLogger;

class LogSuccessfulLogin
{
    protected $timeLogger;
    
    public function __construct(TimeLogger $timeLogger) {
        $this->timeLogger = $timeLogger;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $this->timeLogger->log($event->user)->start();
    }
}
