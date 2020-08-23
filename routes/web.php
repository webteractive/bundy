<?php

use Illuminate\Support\Facades\Route;

Route::layout('layouts.auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::livewire('login', 'auth.login')
            ->name('login');

        Route::livewire('register', 'auth.register')
            ->name('register');
    });

    Route::livewire('password/reset', 'auth.passwords.email')
        ->name('password.request');

    Route::livewire('password/reset/{token}', 'auth.passwords.reset')
        ->name('password.reset');

    Route::middleware('auth')->group(function () {
        Route::livewire('email/verify', 'auth.verify')
            ->middleware('throttle:6,1')
            ->name('verification.notice');

        Route::livewire('password/confirm', 'auth.passwords.confirm')
            ->name('password.confirm');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', 'Auth\EmailVerificationController')
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', 'Auth\LogoutController')
        ->name('logout');

    
    Route::layout('layouts.app')->section('content')->group(function () {
        Route::livewire('/notifs', 'bundy.notification')->name('notification');
        Route::livewire('/perfs', 'bundy.performance')->name('performance');
        Route::livewire('/profile/{username}', 'bundy.profile')->name('profile');
        Route::livewire('/me', 'bundy.profile')->name('me');
        Route::livewire('/cal', 'bundy.calendar')->name('calendar');
        Route::livewire('/{date?}', 'bundy.dashboard')->name('home');
    });
});