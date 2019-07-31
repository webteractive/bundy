<?php

namespace App\Listeners;

use App\User;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\NewChangeScheduleRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\ChangeScheduleRequestNotification;

class NotifyAdminForChangeScheduleRequest
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewChangeScheduleRequest $event)
    {
        User::admins()->get()->each(function($admin) use ($event) {
        $admin->notify(new ChangeScheduleRequestNotification($event->request));
        });
    }
}
