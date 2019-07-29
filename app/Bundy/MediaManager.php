<?php

namespace App\Bundy;

class MediaManager
{
  public function withUser($user)
  {
    $this->user = $user;
    return $this;
  }
  
  public function store($file)
  {
    # code...
  }
}