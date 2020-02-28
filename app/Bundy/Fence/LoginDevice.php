<?php

namespace App\Bundy\Fence;

use App\User;
use App\UserLogin;
use Jenssegers\Agent\Agent;
use App\Bundy\Fence\Events\NewDeviceLoggedIn;

class LoginDevice
{
  protected $request;

  public function __construct($request) {
    $this->request = $request;
  }

  public function log()
  {
    $agent = new Agent();

    $identity = [
      'ip' => $this->request->ip(),
      'device' => $agent->device(),
      'languages' => $agent->languages(),
      'browser' => $agent->browser(),
      'platform' => $agent->platform(),
      'userAgent' => $this->request->header('User-Agent'),
    ];

    $user = User::find(auth()->user()->id);
    $serializedIdentity = serialize($identity);
    $hashedIdentity = md5($serializedIdentity);

    $isANewDevice = $user->logins()
                        ->where('hash', $hashedIdentity)
                        ->get()
                        ->isEmpty();

    if ($isANewDevice) {
      event(new NewDeviceLoggedIn($user, $identity));
    }

    $user->logins()->save(new UserLogin([
      'identity' => $identity,
      'hash' => $hashedIdentity,
    ]));
  }
}