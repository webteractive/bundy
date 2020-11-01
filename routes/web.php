<?php

use Illuminate\Support\Facades\Route;

Route::name('login')->get('login', [\App\Http\Controllers\LoginController::class, 'index']);
Route::name('authenticate')->post('api/login', [\App\Http\Controllers\AuthenticationController::class, 'login']);

Route::middleware('auth')->prefix('api')->group(function () {
    Route::name('logout')->any('logout', [\App\Http\Controllers\AuthenticationController::class, 'logout']);

    Route::name('user.refresh')->get('user/refresh', [\App\Http\Controllers\AuthenticationController::class, 'refresh']);

    Route::prefix('profile')->group(function () {
        Route::name('profile.update')->post('update', [\App\Http\Controllers\ProfileController::class, 'update']);

        Route::name('profile.media.store')->post('media/store', [\App\Http\Controllers\ProfileMediaController::class, 'store']);

        Route::name('profile.logs')->get('{username}/logs', [\App\Http\Controllers\ProfileLogsController::class, 'index']);
        Route::name('profile.logs.show')->get('{username}/log/show/{date}', [\App\Http\Controllers\ProfileLogsController::class, 'show']);

        // Route::name('profile.wall')->get('{username}/wall');

        Route::name('profile.leaves')->get('{username}/leaves', [\App\Http\Controllers\ProfileLeavesController::class, 'index']);
        Route::name('profile.leave.store')->post('leave/store', [\App\Http\Controllers\ProfileLeavesController::class, 'store']);
    });

    Route::name('account.password.update')->post('account/password/update', [\App\Http\Controllers\PasswordsController::class, 'update']);

    Route::name('schedules.store')->post('schedules/store', [\App\Http\Controllers\SchedulesController::class, 'store']);
    Route::name('schedules.update')->post('schedules/update', [\App\Http\Controllers\SchedulesController::class, 'update']);

    Route::name('stream')->get('stream/{type?}/{date?}', \App\Http\Controllers\StreamController::class);
    Route::name('presence')->get('presence', \App\Http\Controllers\PresenceController::class);

    Route::name('logs.list')->get('logs', [\App\Http\Controllers\LogsController::class, 'index']);
    Route::name('logs.store')->post('logs/store', [\App\Http\Controllers\LogsController::class, 'store']);

    Route::name('users')->get('users', [\App\Http\Controllers\EmployeeController::class, 'index']);
    Route::name('employee.show')->get('employee/{username}', [\App\Http\Controllers\EmployeeController::class, 'show']);

    Route::name('scrum.store')->post('scrum/store', [\App\Http\Controllers\ScrumController::class, 'store']);

    Route::name('workingRemote.update')->post('working/remote/update', [\App\Http\Controllers\WorkingRemoteController::class, 'update']);

    Route::name('notifications')->get('notifications', [\App\Http\Controllers\NotificationsController::class, 'index']);
    Route::name('notification.update')->post('notification/update/{id}', [\App\Http\Controllers\NotificationsController::class, 'update']);
    Route::name('notification.destroy')->post('notification/destroy/{id}', [\App\Http\Controllers\NotificationsController::class, 'destroy']);
    Route::name('notification.updateAll')->post('notification/update/all', [\App\Http\Controllers\NotificationsController::class, 'updateAll']);
    Route::name('notification.destroyAll')->post('notification/destroy/all', [\App\Http\Controllers\NotificationsController::class, 'destroyAll']);

    // Perf
    Route::name('performance')->get('performance', \App\Http\Controllers\PerformanceController::class);

    Route::prefix('settings')->group(function () {
        Route::name('slack.authorize')->post('slack/authorize', [\App\Http\Controllers\SlackController::class, 'show']);
        Route::name('slack.validate')->get('slack/validate', [\App\Http\Controllers\SlackController::class, 'store']);
    });

    // Admin
    Route::prefix('admin')->group(function () {
        Route::name('admin.stats')->get('stats', \App\Http\Controllers\Admin\StatsController::class);

        Route::prefix('schedule')->group(function () {
            Route::name('admin.schedule.requests')->get('requests', [\App\Http\Controllers\Admin\ScheduleRequestsController::class, 'index']);
            Route::name('admin.schedule.request.update')->post('requests/update/{id}', [\App\Http\Controllers\Admin\ScheduleRequestsController::class, 'update']);
            Route::name('admin.schedule.request.destroy')->post('requests/destroy/{id}', [\App\Http\Controllers\Admin\ScheduleRequestsController::class, 'destroy']);
        });

        Route::prefix('users')->group(function () {
            Route::name('admin.users')->get('users', [\App\Http\Controllers\Admin\UsersController::class, 'index']);
            Route::name('admin.users.store')->post('store', [\App\Http\Controllers\Admin\UsersController::class, 'store']);
            Route::name('admin.users.update')->post('update/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'update']);
            Route::name('admin.users.password.reset')->post('password/reset/{id}', [\App\Http\Controllers\Admin\UserPasswordsController::class, 'update']);
        });
    });
});

Route::prefix('tall')->group(function () {
    Route::middleware('auth')->group(function() {
        Route::get('/', \App\Bundy\Livewire\Home::class)->name('tall.home');
        Route::get('/me/edit', \App\Bundy\Livewire\Profile\Edit::class)->name('tall.profile.edit');
        Route::get('/me/{username}', \App\Bundy\Livewire\Profile\Index::class)->name('tall.profile');
        Route::get('/perf', \App\Bundy\Livewire\Home::class)->name('tall.performance');
        Route::get('/conf', \App\Bundy\Livewire\Settings::class)->name('tall.settings');
        Route::get('/notif', \App\Bundy\Livewire\Notifications::class)->name('tall.notifications');
        Route::get('/people', \App\Bundy\Livewire\People::class)->name('tall.people');
        Route::get('/events', \App\Bundy\Livewire\Notifications::class)->name('tall.events');
        
        Route::get('/admin', \App\Bundy\Livewire\Admin\Index::class)
            ->middleware('can:manage-admin')
            ->name('tall.admin');
    });
});

Route::name('home')->get('/{page?}/{identifier?}/{inner?}', [\App\Http\Controllers\BundyController::class, 'index']);
