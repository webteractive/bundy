<?php

namespace App\Bundy;

use App\Scrum;
use Illuminate\Support\Facades\DB;

class ScrumMaster
{
  protected $user;

  protected $model;

  protected $slack;

  public function __construct(Scrum $model) {
    $this->model = $model;
    $this->slack = new Slack;
    $this->user = auth()->user();
  }

  public function store($data)
  {
    DB::transaction(function () use ($data) {
      $scrum = $this->model->of($this->user)->today()->first();

      $payload = array_merge($data, [
        'user_id' => $this->user->id
      ]);

      if (is_null($scrum)) {
        $scrum = $this->model->create($payload);
      }

      $scrum->update($payload);

      $slackMethod = is_null($scrum->slack) ? 'postMessage' : 'updateMessage';
      $scrum->update([
        'slack' => $this->slack->{$slackMethod}($scrum, $this->user)
      ]);

    });

    return response()->successful([
      'user' => $this->user->fresh(),
      'message' => __('messages.scrum.posted')
    ]);
  }
}