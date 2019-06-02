<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timelog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'started_at', 'ended_at', 'disputed', 'dispute_reason', 'user_id'
    ];
}
