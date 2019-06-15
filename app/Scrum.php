<?php

namespace App;

use App\Bundy\Streamable;
use App\Bundy\ShouldStream;
use Illuminate\Database\Eloquent\Model;

class Scrum extends Model implements Streamable
{
    use ShouldStream;

    protected $fillable = [
        'yesterday', 'blockers', 'today', 'user_id'
    ];

    protected $casts = [
        'yesterday' => 'array',
        'blockers' => 'array',
        'today' => 'array',
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
        return 'scrum';
    }

    public function streamDateField()
    {
        return 'created_at';
    }
}
