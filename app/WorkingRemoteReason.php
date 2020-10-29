<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bundy\ShouldSerializeDateToDateTimeString;

class WorkingRemoteReason extends Model
{
    use ShouldSerializeDateToDateTimeString;

    protected $fillable = [
        'reason', 'ip', 'worked_on', 'user_id'
    ];

    public function scopePending($query)
    {
        return $query->whereNull('approved_at');
    }

    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_at');
    }
}
