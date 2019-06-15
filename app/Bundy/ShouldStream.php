<?php

namespace App\Bundy;

trait ShouldStream
{
  public function getStreamTypeAttribute()
  {
    return $this->streamType();
  }

  public function getStreamDateAttribute()
  {
    return $this->{$this->streamDateField()};
  }
}
