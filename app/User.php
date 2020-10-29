<?php

namespace App;

use App\Bundy\GateKeeper;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Bundy\ShouldSerializeDateToDateTimeString;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, InteractsWithMedia, ShouldSerializeDateToDateTimeString;

    const ADMIN = 1;
    const EMPLOYEES = 2;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'username', 'alias', 'dob',
        'bio', 'position', 'level', 'address', 'photo', 'cover', 'role_id',
        'contact_numbers', 'links'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'contact_numbers' => 'array',
        'links' => 'array',
        'photo' => 'array',
        'cover' => 'array',
    ];

    protected $with = [
        'role',
        'slack',
        'schedules',
        'scrumsToday',
        'todaysScrum',
        'todaysTimeLog',
        'timeLogsToday',
        'todaysWorkingRemoteReason'
    ];

    protected $appends = [
        'name',
        'permissions',
        'is_admin',
        'is_not_admin'
    ];

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getPermissionsAttribute()
    {
        return (new GateKeeper)
                    ->user($this)
                    ->can([
                        'manage-admin'
                    ])
                    ->get();
    }

    public function getIsAdminAttribute()
    {
        return $this->isAdmin();
    }

    public function getIsNotAdminAttribute()
    {
        return $this->isNotAdmin();
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

    public function workingRemoteReasons()
    {
        return $this->hasMany(WorkingRemoteReason::class);
    }

    public function todaysWorkingRemoteReason()
    {
        return $this->hasOne(WorkingRemoteReason::class)
                    ->whereDate('worked_on', now()->toDateString());
    }

    public function slack()
    {
        return $this->hasOne(UserSlack::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }
    
    public function scopeAdmins($query)
    {
        return $query->where('role_id', self::ADMIN);
    }

    public function scopeEmployees($query)
    {
        return $query->where('role_id', self::EMPLOYEES);
    }

    public function scopeOthers($query)
    {
        return $query->where('id', '<>', auth()->user()->id);
    }

    public function isNotAdmin()
    {
        return $this->role_id !== self::ADMIN;
    }

    public function isAdmin()
    {
        return $this->role_id === self::ADMIN;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover');
        $this->addMediaCollection('photo');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('banner')
            ->fit(Manipulations::FIT_CONTAIN, 1500, 500)
            ->nonQueued();

        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10)
            ->nonQueued();
        
        $this->addMediaConversion('small')
            ->crop(Manipulations::CROP_CENTER, 120, 120)
            ->nonQueued();

        $this->addMediaConversion('smaller')
            ->crop(Manipulations::CROP_CENTER, 64, 64)
            ->nonQueued();
        
        $this->addMediaConversion('smallest')
            ->crop(Manipulations::CROP_CENTER, 32, 32)
            ->nonQueued();
    }
}
