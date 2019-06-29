<?php

namespace App\Bundy;

use Illuminate\Support\Facades\DB;

class NotificationManager
{
  protected $user;

  public function __construct() {
    $this->user = auth()->user();
  }

  public function markAsRead($id)
  {
    DB::transaction(function () use ($id) {
      tap($this->user->notifications()->find($id), function($notification) {
        $notification->markAsRead();
      });
    });

    return response()->successful();
  }

  public function destroy($id)
  {
    DB::transaction(function () use ($id) {
      $notification = $this->user->notifications()->find($id);
      $notification->delete();
    });

    return response()->successful();
  }

  public function markAllAsRead()
  {
    DB::transaction(function () {
      $this->user->notifications()->markAsRead();
    });

    return response()->successful();
  }

  public function destroyAll()
  {
    DB::transaction(function () {
      $this->user->notifications()->delete();
    });

    return response()->successful();
  }
}