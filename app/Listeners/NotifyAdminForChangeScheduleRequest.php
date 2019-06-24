<?php

namespace App\Listeners;

use App\Events\ChangeScheduleRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdminForChangeScheduleRequest
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ChangeScheduleRequested $event)
    {
        logger()->info('Fired', [$event]);
    }
}
