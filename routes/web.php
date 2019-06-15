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
  Route::name('logout')->post('logout', 'AuthenticationController@logout');

  Route::name('schedules.update')->post('schedules/update', 'SchedulesController@update');

  Route::name('stream')->get('stream', 'StreamController');
  Route::name('presence')->get('presence', 'PresenceController');

  Route::name('logs.list')->get('logs/list', 'LogsController@index');
  Route::name('logs.store')->post('logs/store', 'LogsController@store');
  
  Route::name('employee.list')->get('employee/list', 'EmployeeController@index');
  Route::name('employee.show')->get('employee/{username?}', 'EmployeeController@show');
  
  Route::name('scrum.store')->post('scrum/store', 'ScrumController@store');
  Route::name('scrum.update')->post('scrum/update/{id?}', 'ScrumController@store');
});


Route::name('home')->get('/{page?}/{identifier?}/{inner?}', 'BundyController@index');