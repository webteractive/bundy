<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Listeners\LogSuccessfulLogin;
use App\Listeners\LogSuccessfulLogout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\NewChangeScheduleRequest;
use App\Listeners\NotifyAdminForChangeScheduleRequest;
use App\Events\Admin\NewUserCreated;
use App\Listeners\Admin\WelcomeNewUser;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        Login::class => [
            LogSuccessfulLogin::class
        ],

        Logout::class => [
            LogSuccessfulLogout::class
        ],

        NewChangeScheduleRequest::class => [
            NotifyAdminForChangeScheduleRequest::class
        ],

        NewUserCreated::class => [
            WelcomeNewUser::class
        ]
        
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
