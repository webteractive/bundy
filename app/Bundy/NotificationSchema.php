<?php

namespace App\Bundy;

class NotificationSchema 
{

  protected $type = 'default';

  public function make($type)
  {
    $this->type = $type;
    return $this;
  }

  public function with($payload)
  {
    return array_merge($payload ?? [], [
      'type' => $this->type
    ]);
  }

}