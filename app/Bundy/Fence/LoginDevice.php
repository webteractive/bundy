<?php

namespace App\Bundy\Fence;

use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;

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

    $serializedIdentity = serialize($identity);
    $hashedIdentity = bcrypt($serializedIdentity);

    if (Hash::check($serializedIdentity, $hashedIdentity)) {
      logger()->info('Skip since it is the same');
    } else {
      logger()->info('Notify Admin and the User');
    }
  }
}