<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\BundyController;
use App\Http\Controllers\ScrumController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SlackController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\PasswordsController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\ProfileLogsController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\ProfileMediaController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ProfileLeavesController;
use App\Http\Controllers\WorkingRemoteController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Admin\UserPasswordsController;
use App\Http\Controllers\Admin\ScheduleRequestsController;

Route::name('login')->get('login', [LoginController::class, 'index']);
Route::name('authenticate')->post('api/login', [AuthenticationController::class, 'login']);

Route::middleware('auth')->prefix('api')->group(function () {
    Route::name('logout')->any('logout', [AuthenticationController::class, 'logout']);

    Route::name('user.refresh')->get('user/refresh', [AuthenticationController::class, 'refresh']);

    Route::prefix('profile')->group(function () {
        Route::name('profile.update')->post('update', [ProfileController::class, 'update']);

        Route::name('profile.media.store')->post('media/store', [ProfileMediaController::class, 'store']);

        Route::name('profile.logs')->get('{username}/logs', [ProfileLogsController::class, 'index']);
        Route::name('profile.logs.show')->get('{username}/log/show/{date}', [ProfileLogsController::class, 'show']);

        // Route::name('profile.wall')->get('{username}/wall');

        Route::name('profile.leaves')->get('{username}/leaves', [ProfileLeavesController::class, 'index']);
        Route::name('profile.leave.store')->post('leave/store', [ProfileLeavesController::class, 'store']);
    });

    Route::name('account.password.update')->post('account/password/update', [PasswordsController::class, 'update']);

    Route::name('schedules.store')->post('schedules/store', [SchedulesController::class, 'store']);
    Route::name('schedules.update')->post('schedules/update', [SchedulesController::class, 'update']);

    Route::name('stream')->get('stream/{type?}/{date?}', StreamController::class);
    Route::name('presence')->get('presence', PresenceController::class);

    Route::name('logs.list')->get('logs', [LogsController::class, 'index']);
    Route::name('logs.store')->post('logs/store', [LogsController::class, 'store']);

    Route::name('users')->get('users', [EmployeeController::class, 'index']);
    Route::name('employee.show')->get('employee/{username}', [EmployeeController::class, 'show']);

    Route::name('scrum.store')->post('scrum/store', [ScrumController::class, 'store']);

    Route::name('workingRemote.update')->post('working/remote/update', [WorkingRemoteController::class, 'update']);

    Route::name('notifications')->get('notifications', [NotificationsController::class, 'index']);
    Route::name('notification.update')->post('notification/update/{id}', [NotificationsController::class, 'update']);
    Route::name('notification.destroy')->post('notification/destroy/{id}', [NotificationsController::class, 'destroy']);
    Route::name('notification.updateAll')->post('notification/update/all', [NotificationsController::class, 'updateAll']);
    Route::name('notification.destroyAll')->post('notification/destroy/all', [NotificationsController::class, 'destroyAll']);

    // Perf
    Route::name('performance')->get('performance', PerformanceController::class);

    Route::prefix('settings')->group(function () {
        Route::name('slack.authorize')->post('slack/authorize', [SlackController::class, 'show']);
        Route::name('slack.validate')->get('slack/validate', [SlackController::class, 'store']);
    });

    // Admin
    Route::prefix('admin')->group(function () {
        Route::name('admin.stats')->get('stats', StatsController::class);

        Route::prefix('schedule')->group(function () {
            Route::name('admin.schedule.requests')->get('requests', [ScheduleRequestsController::class, 'index']);
            Route::name('admin.schedule.request.update')->post('requests/update/{id}', [ScheduleRequestsController::class, 'update']);
            Route::name('admin.schedule.request.destroy')->post('requests/destroy/{id}', [ScheduleRequestsController::class, 'destroy']);
        });

        Route::prefix('users')->group(function () {
            Route::name('admin.users')->get('users', [UsersController::class, 'index']);
            Route::name('admin.users.store')->post('store', [UsersController::class, 'store']);
            Route::name('admin.users.update')->post('update/{id}', [UsersController::class, 'update']);
            Route::name('admin.users.password.reset')->post('password/reset/{id}', [UserPasswordsController::class, 'update']);
        });
    });
});

Route::prefix('tall')->group(function () {
    Route::middleware('auth')->group(function() {
        Route::get('/', \App\Bundy\Livewire\Home::class)->name('tall.home');
        Route::get('/notif', \App\Bundy\Livewire\Home::class)->name('tall.notification');
        Route::get('/me/edit', \App\Bundy\Livewire\Profile\Edit::class)->name('tall.profile.edit');
        Route::get('/me/{username}', \App\Bundy\Livewire\Profile\Index::class)->name('tall.profile');
        Route::get('/conf', \App\Bundy\Livewire\Home::class)->name('tall.settings');
        Route::get('/perf', \App\Bundy\Livewire\Home::class)->name('tall.performance');
    });
});

Route::name('home')->get('/{page?}/{identifier?}/{inner?}', [BundyController::class, 'index']);
