<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bundy\ShouldSerializeDateToDateTimeString;

class Role extends Model
{
    use ShouldSerializeDateToDateTimeString;

    protected $fillable = [
        'name', 'description', 'permissions'
    ];
}
