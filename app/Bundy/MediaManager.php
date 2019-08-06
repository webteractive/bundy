<?php

namespace App\Bundy;

use Illuminate\Support\Facades\DB;

class MediaManager
{
  protected $user;

  protected $media;

  public function withUser($user)
  {
    $this->user = $user;
    return $this;
  }
  
  public function storeTo($collection)
  {
    DB::transaction(function () use ($collection) {
      $this->media = $this->user->addMediaFromRequest('file')
                                ->toMediaCollection($collection);
      $this->user->update([
        $collection => [
          'original' => $this->media->getUrl(),
          'small' => $this->media->getUrl('small'),
          'banner' => $this->media->getUrl('banner'),
          'smaller' => $this->media->getUrl('smaller'),
          'smallest' => $this->media->getUrl('smallest'),
        ]
      ]);
    });

    return response()->successful([
      'message' => __('messages.profile.media.updated', ['collection' => $collection]),
      'user' => $this->user->fresh()
    ]);
  }
}