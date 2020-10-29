<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bundy\ShouldSerializeDateToDateTimeString;

class UserSlack extends Model
{
    use ShouldSerializeDateToDateTimeString;
    
    protected $fillable = [
        'settings', 'user_id'
    ];

    protected $casts = [
        'settings' => 'array',
    ];
}
