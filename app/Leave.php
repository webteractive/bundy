<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    const REJECTED = -1;
    const PENDING = 0;
    const APPROVED = 1;
    const CANCELLED = 2;

    protected $fillable = [
        'starts_on', 'ends_on', 'description', 'status', 'user_id'
    ];

    protected $casts = [
        'starts_on' => 'datetime',
        'ends_on' => 'datetime',
    ];

    protected $appends = [
        'archived',
        'upcoming',
        'today',
        'duration'
    ];

    public function getArchivedAttribute()
    {
        return $this->starts_on->isPast();
    }

    public function getUpcomingAttribute()
    {
        return $this->starts_on->isFuture();
    }

    public function getDurationAttribute()
    {
        return $this->ends_on->floatDiffInDays($this->starts_on);
    }

    public function getTodayAttribute()
    {
        return $this->starts_on->isToday();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeBy($query, $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeUpcoming($query)
    {
        return $query->whereDate('starts_on', '>=',  now()->toDateString());
    }
}
