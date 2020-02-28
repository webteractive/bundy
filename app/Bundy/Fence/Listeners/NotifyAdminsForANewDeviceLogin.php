<?php

namespace App\Bundy\Fence\Listeners;

use App\Bundy\Fence\Notifications\NewDeviceLoginNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminsForANewDeviceLogin implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event->user->notify(new NewDeviceLoginNotification('admin', $event->user, $event->identity));

    }
}
