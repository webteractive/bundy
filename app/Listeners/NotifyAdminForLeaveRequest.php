<?php

namespace App\Listeners;

use App\Events\LeaveRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\LeaveRequestNotification;
use App\User;

class NotifyAdminForLeaveRequest
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LeaveRequested  $event
     * @return void
     */
    public function handle(LeaveRequested $event)
    {
        User::admins()->get()->each(function($admin) use ($event) {
            $admin->notify(new LeaveRequestNotification($event->leave));
        });
    }
}
