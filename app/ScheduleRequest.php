<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleRequest extends Model
{
    protected $fillable = [
        'from', 'to', 'approved', 'user_id', 'reason'
    ];

    protected $casts = [
        'to' => 'array',
        'from' => 'array',
        'approved' => 'boolean',
    ];
}
