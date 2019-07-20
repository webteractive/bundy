<?php

namespace App\Listeners\Admin;

use App\Mail\WelcomeEmail;
use App\Events\Admin\NewUserCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeNewUser
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewUserCreated $event)
    {
        Mail::to($event->user->email)->send(new WelcomeEmail($event->user, $event->password));
    }
}
