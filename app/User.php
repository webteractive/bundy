<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'username', 'alias',
        'bio', 'position', 'level', 'address', 'photo', 'cover',
        'contact_numbers', 'links'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'contact_numbers' => 'array',
        'links' => 'array',
    ];

    protected $with = [
        'role',
        'schedules',
        'scrumsToday',
        'todaysScrum',
        'todaysTimeLog',
        'timeLogsToday'
    ];

    protected $appends = [
        'name'
    ];

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class)
                    ->as('details')
                    ->withPivot('day')
                    ->withTimestamps();
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
    
    public function scopeAdmins($query)
    {
        return $query->where('role_id', 1);
    }
}
