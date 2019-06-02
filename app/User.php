<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'scheduled'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'scheduled' => 'boolean'
    ];

    protected $with = [
        'schedules',
        'timelogsToday'
    ];

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class)
                    ->as('details')
                    ->withPivot('day');
    }

    public function timelogsToday()
    {
        return $this->hasMany(Timelog::class)
                    ->whereDate('started_at', now()->toDateString())
                    ->oldest('started_at');
    }
}
