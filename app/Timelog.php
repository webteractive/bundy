<?php

namespace App;

use App\Bundy\Streamable;
use App\Bundy\ShouldStream;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model implements Streamable
{
    use ShouldStream;

    const EARLINESS = 30;
    
    protected $fillable = [
        'started_at', 'ended_at', 'disputed', 'dispute_reason', 'schedule_id', 'user_id'
    ];

    protected $casts = [
        'disputed' => 'boolean',
        'ended_at' => 'datetime',
        'started_at' => 'datetime',
    ];

    protected $appends = [
        'stream_type',
        'stream_date',
        'late',
        'on_time',
        'early_bird',
        'schedule_starts_at',
        'tardiness',
        'punctuality',
        'rendered_time',
        'on_grace_period',
        'undertime'
    ];

    public function getScheduleStartsAtAttribute()
    {
        [$hour, $minute] = explode(':', $this->schedule->starts_at ?? $this->started_at);
        return $this->started_at->set('hour', $hour)
                                ->set('minute', $minute)
                                ->set('second', 0);
    }

    public function getLateAttribute()
    {
        $durationOfLate = $this->schedule_starts_at->diffInRealMinutes($this->started_at);
        return $this->started_at->isAfter($this->schedule_starts_at) && $durationOfLate > $this->schedule->grace_period;
    }

    public function getOnTimeAttribute()
    {   
        if ($this->late) {
            return false;
        }

        if ($this->started_at->eq($this->schedule_starts_at)) {
            return true;
        }

        $durationOfLate = $this->schedule_starts_at->diffInRealMinutes($this->started_at);

        if ($this->started_at->isAfter($this->schedule_starts_at) && ($durationOfLate <= $this->schedule->grace_period)) {
            return true;
        }
        
        return $this->schedule_starts_at->diffInRealMinutes($this->started_at) <= self::EARLINESS;
    }

    public function getEarlyBirdAttribute()
    {
        if ($this->on_time) {
            return false;
        }

        return $this->started_at->isBefore($this->schedule_starts_at) 
                && $this->schedule_starts_at->diffInRealMinutes($this->started_at) > self::EARLINESS;
    }

    public function getPunctualityAttribute()
    {
        return ($this->on_time || $this->early_bird)
                    ? $this->schedule_starts_at->longAbsoluteDiffForHumans($this->started_at)
                    : null; 
    }

    public function getTardinessAttribute()
    {
        return $this->late
                    ? $this->schedule_starts_at->longAbsoluteDiffForHumans($this->started_at)
                    : null;
    }

    public function getRenderedTimeAttribute()
    {
        if (is_null($this->ended_at)) {
            return null;
        }

        return number_format($this->ended_at->floatDiffInHours($this->started_at), 2);
    }

    public function getUndertimeAttribute()
    {
        if (is_null($this->ended_at)) {
            return true;
        }

        return number_format($this->ended_at->floatDiffInHours($this->started_at), 2) < 8;
    }

    public function getOnGracePeriodAttribute()
    {
        if ($this->on_time) {
            $durationOfLate = $this->schedule_starts_at->diffInRealMinutes($this->started_at);
            return $this->started_at->isAfter($this->schedule_starts_at) && ($durationOfLate <= $this->schedule->grace_period);
        }

        return false;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
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

    public function scopeToday($query)
    {
        return $query->whereDate('started_at', now()->toDateString());
    }
}
