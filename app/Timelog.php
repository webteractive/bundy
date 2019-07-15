<?php

namespace App;

use App\Bundy\Streamable;
use App\Bundy\ShouldStream;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model implements Streamable
{
    use ShouldStream;
    
    protected $fillable = [
        'started_at', 'ended_at', 'disputed', 'dispute_reason', 'schedule_id', 'user_id'
    ];

    protected $casts = [
        'disputed' => 'boolean',
    ];

    protected $appends = [
        'stream_type',
        'stream_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function streamType()
    {
        return 'time_log';
    }

    public function streamDateField()
    {
        return 'started_at';
    }

    public function scopeOf($query, $user)
    {
        return $query->where('user_id', $user->id);
    }
}
