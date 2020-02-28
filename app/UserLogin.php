<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    protected $fillable = [
        'hash',
        'user_id',
        'identity',
    ];

    protected $casts = [
        'identity' => 'array',
    ];
}
