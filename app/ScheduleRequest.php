<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleRequest extends Model
{
    protected $fillable = [
        'from', 'to', 'reason', 'approved', 'user_id'
    ];

    protected $casts = [
        'to' => 'array',
        'from' => 'array'
    ];

    protected $with = [
        'user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved($query)
    {
        return $query->whereApproved(1);
    }

    public function scopePending($query)
    {
        return $query->whereApproved(null);
    }

    public function scopeDisapproved($query)
    {
        return $query->whereApproved(0);
    }
}
