<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkingRemoteReason extends Model
{
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
