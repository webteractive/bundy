<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'starts_at', 'ends_at', 'break'
    ];
    
    protected $appends = [
        'end_date_at',
        'start_date_at',
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
}
