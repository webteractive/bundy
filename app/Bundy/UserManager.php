<?php

namespace App\Bundy;

use App\User as Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Events\Admin\NewUserCreated;

class UserManager
{
  protected $user;

  protected $model;

  protected $passwordText;

  public function __construct(Model $model) {
    $this->model = $model;
  }

  public function create($data)
  {
    DB::transaction(function () use ($data) {
      $this->passwordText = Str::random(12);
      $this->user = $this->model->create(array_merge($data, [
        'alias' => $data['first_name'],
        'password' => bcrypt($this->passwordText),
        'username' => Str::slug(join(' ', [$data['first_name'], $data['last_name']])),
      ]));
    });
    
    event(new NewUserCreated($this->user, $this->passwordText));

    return response()->successful([
      'message' => __('message.user.created')
    ]);
  }
}
