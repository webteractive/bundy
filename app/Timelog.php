<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'started_at', 'ended_at', 'disputed', 'dispute_reason', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
