<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\PasswordChanged as PasswordChangedMail;
use App\Events\PasswordChanged as PasswordChangedEvent;
use Illuminate\Support\Facades\Mail;

class NotifyUserForPasswordChange
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
     * @param  object  $event
     * @return void
     */
    public function handle(PasswordChangedEvent $event)
    {
        Mail::to($event->user)->send(new PasswordChangedMail($event));
    }
}
