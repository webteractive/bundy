<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bundy\ShouldSerializeDateToDateTimeString;

class Schedule extends Model
{
    use ShouldSerializeDateToDateTimeString;

    protected $fillable = [
        'starts_at', 'ends_at', 'break', 'grace_period'
    ];
    
    protected $appends = [
        'end_date_at',
        'start_date_at',
        'ends_at_display',
        'starts_at_display',
    ];

    public function getStartDateAtAttribute()
    {   
        [$hour, $minutes] = explode(':', $this->starts_at);
        return now()->setTime($hour, $minutes)->toDateTimeString();
    }

    public function getEndDateAtAttribute()
    {   
        [$hour, $minutes] = explode(':', $this->ends_at);
        return now()->setTime($hour, $minutes)->toDateTimeString();
    }

    public function getStartsAtDisplayAttribute()
    {
        [$hour, $minutes] = explode(':', $this->starts_at);
        return now()->setTime($hour, $minutes)->format('g:i A');
    }

    public function getEndsAtDisplayAttribute()
    {
        [$hour, $minutes] = explode(':', $this->ends_at);
        return now()->setTime($hour, $minutes)->format('g:i A');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
                        ->as('details')
                        ->withPivot('day')
                        ->withTimestamps();
    }
}
