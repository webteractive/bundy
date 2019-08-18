<?php

namespace App\Bundy;

class NotificationSchema 
{
  protected $type;

  public function __construct($type) {
    $this->type = $type;
  }

  public function with($data = [])
  {
    return array_merge($data, [
      'type' => $this->type
    ]);
  }
}