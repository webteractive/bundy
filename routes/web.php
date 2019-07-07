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

Route::name('login')->post('void/login', 'AuthenticationController@login');

Route::middleware('auth')->prefix('void')->group(function() {
  Route::name('logout')->any('logout', 'AuthenticationController@logout');

  Route::name('user.refresh')->get('user/refresh', 'AuthenticationController@refresh');
  
  Route::name('profile.update')->post('update-profile', 'ProfileController@update');

  Route::name('schedules.store')->post('schedules/store', 'SchedulesController@store');
  Route::name('schedules.update')->post('schedules/update', 'SchedulesController@update');

  Route::name('stream')->get('stream/{date?}', 'StreamController');
  Route::name('presence')->get('presence', 'PresenceController');

  Route::name('logs.list')->get('logs', 'LogsController@index');
  Route::name('logs.store')->post('logs/store', 'LogsController@store');
  
  Route::name('employee.list')->get('employees', 'EmployeeController@index');
  Route::name('employee.show')->get('employee/{username}', 'EmployeeController@show');
  
  Route::name('scrum.store')->post('scrum/store', 'ScrumController@store');
  Route::name('scrum.update')->post('scrum/update/{id}', 'ScrumController@update');

  Route::name('workingRemote.update')->post('working/remote/update', 'WorkingRemoteController@update');

  Route::name('notifications')->get('notifications', 'NotificationsController@index');
  Route::name('notification.update')->post('notification/update/{id}', 'NotificationsController@update');
  Route::name('notification.destroy')->post('notification/destroy/{id}', 'NotificationsController@destroy');
  Route::name('notification.updateAll')->post('notification/update/all', 'NotificationsController@updateAll');
  Route::name('notification.destroyAll')->post('notification/destroy/all', 'NotificationsController@destroyAll');

  // Admin
  Route::prefix('admin')->group(function() {
    Route::name('admin.stats')->get('stats', 'Admin\StatsController');
  
    Route::name('admin.schedule.list')->get('schedule/list', 'Admin\ScheduleRequestsController@index');
    Route::name('admin.schedule.update')->post('schedule/update/{id}', 'Admin\ScheduleRequestsController@update');
  });
});

Route::name('home')->get('/{page?}/{identifier?}/{inner?}', 'BundyController@index');