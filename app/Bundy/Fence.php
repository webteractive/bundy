<?php

namespace App\Bundy;

use App\WorkingRemoteReason;
use Illuminate\Support\Facades\DB;

class Fence
{
  protected $ip;

  protected $env;

  protected $user;

  protected $allowed;

  public function __construct($ip) 
  {
    $this->ip = $ip;
    $this->env = config('app.env');
    $this->allowed = config('app.ips');
  }

  public function check()
  {
    if (in_array($this->env, ['local', 'development'])) {
      return false;
    }

    return ! in_array($this->ip, $this->allowed);
  }

  public function withUser($user)
  {
    $this->user = $user;
    return $this;
  }

  public function logAccess($reason = '')
  {
    $needle = [
      'user_id' => $this->user->id,
      'worked_on' => now()->toDateString()
    ];

    return WorkingRemoteReason::firstOrCreate(
      $needle,
      array_merge([
        'ip' => $this->ip,
        'reason' => $reason,
      ], $needle)
    );
  }

  public function updateReason($payload)
  {
    DB::transaction(function () use ($payload) {
      tap(WorkingRemoteReason::where([
        'user_id' => $this->user->id,
        'worked_on' => now()->toDateString()
      ]), function($entry) use ($payload) {
        $entry->update($payload);
      });
    });

    return response()->successful([
      'user' => $this->user->fresh(),
      'message' => __('messages.working_remote.updated')
    ]);
  }
}