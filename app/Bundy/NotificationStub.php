<?php

namespace App\Bundy;

use Illuminate\Notifications\Messages\BroadcastMessage;

trait NotificationStub 
{
  public function via($notifiable)
  {
    return ['mail', 'broadcast', 'database'];
  }
  
  public function toArray($notifiable)
  {
    return $this->payload();
  }
  
  public function toBroadcast($notifiable)
  {
    return new BroadcastMessage($this->payload());
  }

  protected function payload()
  {
    return (new NotificationSchema($this->asType()))->with($this->toPayload());
  }

  abstract function toPayload();

  abstract function asType();
}