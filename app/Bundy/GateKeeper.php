<?php

namespace App\Bundy;

use App\User;
use Illuminate\Support\Collection;

class GateKeeper
{
  protected $user;

  protected $permissions;

  public function can(array $permissions) {
    $this->permissions = $permissions;
    return $this;
  }

  public function user(User $user)
  {
    $this->user = $user;
    return $this;
  }

  public function get()
  {
    $permissions = new Collection();
    foreach ($this->permissions as $permission) {
      if ($this->user->can($permission)) {
        $permissions->push($permission);
      }
    }

    return $permissions->toArray();
  }

}
