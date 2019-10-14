<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleRequest extends Model
{
    const APPROVED = 1;
    const PENDING = null;
    const DISAPPROVED = 0;

    protected $fillable = [
        'to',
        'from',
        'reason',
        'user_id',
        'approved',
        'action_reason'
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
        return $query->whereApproved(self::APPROVED);
    }

    public function scopePending($query)
    {
        return $query->whereApproved(self::PENDING);
    }

    public function scopeDisapproved($query)
    {
        return $query->whereApproved(self::DISAPPROVED);
    }
}
