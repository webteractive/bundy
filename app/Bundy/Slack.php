<?php

namespace App\Bundy;

use Zttp\Zttp;
use App\UserSlack;

class Slack
{
  public function authorize($username)
  {
    return response()->successful([
      'authorization_url' => 'https://slack.com/oauth/authorize?' . http_build_query([
        'client_id' => config('services.slack.key'),
        'redirect_uri' => route('slack.validate'),
        'scope' => 'chat:write:bot chat:write:user',
        'state' => encrypt($username),
        'team' => config('app.scrum.slack_team')
      ])
    ]);
  }

  public function validate($user, $payload)
  {
    abort_if(isset($payload['error']) && $payload['error'] === 'access_denied', 401, $payload['error'] ?? '');

    if ($user->username === decrypt($payload['state'])) {

      $result = Zttp::asFormParams()->post('https://slack.com/api/oauth.access', [
        'code' => $payload['code'],
        'redirect_uri' => route('slack.validate'),
        'client_id' => config('services.slack.key'),
        'client_secret' => config('services.slack.secret'),
      ]);

      UserSlack::updateOrCreate(
        ['user_id' => $user->id],
        ['user_id' => $user->id, 'settings' => (array) $result->json()]
      );

      return redirect()->route('home', ['page' => 'scrum_settings']);
    }

    abort(404);
  }

  public function postMessage($scrum, $user)
  {
    if (is_null($user->slack)) {
      return null;
    }

    return (array) Zttp::asFormParams()
              ->post('https://slack.com/api/chat.postMessage',[
                'token' => $user->slack->settings['access_token'],
                'channel' => config('app.scrum.slack_channel'),
                'text' => (new ScrumSlackMessage($scrum))->toMessage(),
                'as_user' => true
              ])
              ->json();
  }

  public function updateMessage($scrum, $user)
  {
    if (is_null($user->slack)) {
      return null;
    }

    return (array) Zttp::asFormParams()
              ->post('https://slack.com/api/chat.update',[
                'token' => $user->slack->settings['access_token'],
                'channel' => $scrum->slack['channel'] ?? config('app.scrum.slack_channel'),
                'text' => (new ScrumSlackMessage($scrum))->toMessage(),
                'as_user' => true,
                'ts' => $scrum->slack['ts'] ?? null
              ])
              ->json();
  }
}