<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bundy\ShouldSerializeDateToDateTimeString;

class ScheduleRequest extends Model
{
    use ShouldSerializeDateToDateTimeString;

    const APPROVED = 1;
    const PENDING = null;
    const REJECTED = 0;

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
        return $query->whereApproved(self::REJECTED);
    }

    public function scopeRejected($query)
    {
        return $query->whereApproved(self::REJECTED);
    }

    public function isApproved()
    {
        return $this->approved === self::APPROVED;
    }

    public function isRejected()
    {
        return $this->approved === self::REJECTED;
    }
}
