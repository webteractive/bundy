<?php

namespace App\Listeners;

use App\Events\ChangeScheduleRequestUpdated;
use App\Notifications\UpdatedScheduleRequestNotification;

class NotifyUserForTheUpdatedScheduleRequest
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ChangeScheduleRequestUpdated $event)
    {
        $event->scheduleRequest->user->notify(
            new UpdatedScheduleRequestNotification($event->scheduleRequest)
        );
    }
}
