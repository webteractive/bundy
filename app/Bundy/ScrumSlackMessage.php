<?php

namespace App\Bundy;

use App\Scrum;

class ScrumSlackMessage
{
  protected $scrum;

  public function __construct(Scrum $scrum) {
    $this->scrum = $scrum;
  }

  public function toMessage()
  {
    $messages = '';
    if (! empty($this->scrum->yesterday)) {
      $messages .= "*Yesterday*\n";
      foreach ($this->scrum->yesterday as $message) {
        $messages .= '>' . $message . "\n";
      }
    }

    if (! empty($this->scrum->blockers)) {
      $messages .= "*Blockers*\n";
      foreach ($this->scrum->blockers as $message) {
        $messages .= '>' . $message . "\n";
      }
    }

    if (! empty($this->scrum->today)) {
      $messages .= "*Today*\n";
      foreach ($this->scrum->today as $message) {
        $messages .= '>' . $message . "\n";
      }
    }

    return $messages;
  }
}