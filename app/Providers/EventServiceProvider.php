<?php

namespace App\Providers;

use App\Events\LeaveRequested;
use App\Events\PasswordChanged;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Events\Admin\NewUserCreated;
use App\Listeners\LogSuccessfulLogin;
use App\Listeners\LogSuccessfulLogout;
use Illuminate\Auth\Events\Registered;
use App\Listeners\Admin\WelcomeNewUser;
use App\Events\NewChangeScheduleRequest;
use App\Events\ChangeScheduleRequestUpdated;
use App\Bundy\Fence\Events\NewDeviceLoggedIn;
use App\Bundy\Fence\Listeners\NotifyAdminsForANewDeviceLogin;
use App\Bundy\Fence\Listeners\NotifyUserForANewDeviceLogin;
use App\Listeners\NotifyAdminForLeaveRequest;
use App\Listeners\NotifyUserForPasswordChange;
use App\Listeners\NotifyAdminForChangeScheduleRequest;
use App\Listeners\NotifyUserForTheUpdatedScheduleRequest;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
            LogSuccessfulLogin::class,
        ],

        Logout::class => [
            LogSuccessfulLogout::class
        ],

        NewChangeScheduleRequest::class => [
            NotifyAdminForChangeScheduleRequest::class
        ],

        ChangeScheduleRequestUpdated::class => [
            NotifyUserForTheUpdatedScheduleRequest::class
        ],

        NewUserCreated::class => [
            WelcomeNewUser::class
        ],

        PasswordChanged::class => [
            NotifyUserForPasswordChange::class
        ],

        LeaveRequested::class => [
            NotifyAdminForLeaveRequest::class
        ],

        NewDeviceLoggedIn::class => [
            NotifyUserForANewDeviceLogin::class,
            NotifyAdminsForANewDeviceLogin::class,
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
