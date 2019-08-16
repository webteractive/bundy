<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('login')->post('api/login', 'AuthenticationController@login');

Route::middleware('auth')->prefix('api')->group(function() {
  Route::name('logout')->any('logout', 'AuthenticationController@logout');

  Route::name('user.refresh')->get('user/refresh', 'AuthenticationController@refresh');

  Route::prefix('profile')->group(function() {
    Route::name('profile.update')->post('update', 'ProfileController@update');

    Route::name('profile.media.store')->post('media/store', 'ProfileMediaController@store');

    Route::name('profile.logs')->get('{username}/logs', 'ProfileLogsController@index');
    Route::name('profile.logs.show')->get('{username}/log/show/{date}', 'ProfileLogsController@show');
  });

  Route::name('account.password.update')->post('account/password/update', 'PasswordsController@update');

  Route::name('schedules.store')->post('schedules/store', 'SchedulesController@store');
  Route::name('schedules.update')->post('schedules/update', 'SchedulesController@update');

  Route::name('stream')->get('stream/{type?}/{date?}', 'StreamController');
  Route::name('presence')->get('presence', 'PresenceController');

  Route::name('logs.list')->get('logs', 'LogsController@index');
  Route::name('logs.store')->post('logs/store', 'LogsController@store');
  
  Route::name('users')->get('users', 'EmployeeController@index');
  Route::name('employee.show')->get('employee/{username}', 'EmployeeController@show');
  
  Route::name('scrum.store')->post('scrum/store', 'ScrumController@store');

  Route::name('workingRemote.update')->post('working/remote/update', 'WorkingRemoteController@update');

  Route::name('notifications')->get('notifications', 'NotificationsController@index');
  Route::name('notification.update')->post('notification/update/{id}', 'NotificationsController@update');
  Route::name('notification.destroy')->post('notification/destroy/{id}', 'NotificationsController@destroy');
  Route::name('notification.updateAll')->post('notification/update/all', 'NotificationsController@updateAll');
  Route::name('notification.destroyAll')->post('notification/destroy/all', 'NotificationsController@destroyAll');

  // Perf
  Route::name('performance')->get('performance', 'PerformanceController');

  Route::prefix('settings')->group(function() {
    Route::name('slack.authorize')->post('slack/authorize', 'SlackController@show');
    Route::name('slack.validate')->get('slack/validate', 'SlackController@store');
  });

  // Admin
  Route::prefix('admin')->group(function() {
    Route::name('admin.stats')->get('stats', 'Admin\StatsController');
  
    Route::prefix('schedule')->group(function() {
      Route::name('admin.schedule.requests')->get('requests', 'Admin\ScheduleRequestsController@index');
      Route::name('admin.schedule.request.update')->post('requests/update/{id}', 'Admin\ScheduleRequestsController@update');
      Route::name('admin.schedule.request.destroy')->post('requests/destroy/{id}', 'Admin\ScheduleRequestsController@destroy');
    });

    Route::prefix('users')->group(function () {
      Route::name('admin.users')->get('users', 'Admin\UsersController@index');
      Route::name('admin.users.store')->post('store', 'Admin\UsersController@store');
      Route::name('admin.users.update')->post('update/{id}', 'Admin\UsersController@update');
      Route::name('admin.users.password.reset')->post('password/reset/{id}', 'Admin\UserPasswordsController@update');
    });
  });
});

Route::name('home')->get('/{page?}/{identifier?}/{inner?}', 'BundyController@index');