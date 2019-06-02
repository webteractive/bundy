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

Route::name('home')->get('/', 'BundyController@index');

Route::name('login')->post('void/login', 'AuthenticationController@login');

Route::middleware('auth')->prefix('void')->group(function() {
  Route::name('logout')->post('logout', 'AuthenticationController@logout');

  Route::name('schedules.update')->post('schedules/update', 'SchedulesController@update');
});
