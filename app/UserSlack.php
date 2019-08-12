<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSlack extends Model
{
    protected $fillable = [
        'settings', 'user_id'
    ];

    protected $casts = [
        'settings' => 'array',
    ];
}
