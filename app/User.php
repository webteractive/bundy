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
        'role',
        'schedules',
        'scrumsToday',
        'timeLogsToday',
        'todaysScrum',
        'todaysTimeLog'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class)
                    ->as('details')
                    ->withPivot('day');
    }

    public function timeLogsToday()
    {
        return $this->hasMany(TimeLog::class)
                    ->whereDate('started_at', now()->toDateString())
                    ->oldest('started_at');
    }

    public function scrumsToday()
    {
        return $this->hasMany(Scrum::class)
                    ->whereDate('created_at', now()->toDateString());
    }

    public function todaysScrum()
    {
        return $this->hasOne(Scrum::class)
                    ->whereDate('created_at', now()->toDateString());
    }

    public function todaysTimeLog()
    {
        return $this->hasOne(TimeLog::class)
                    ->whereDate('started_at', now()->toDateString())
                    ->oldest('started_at');
    }
}
