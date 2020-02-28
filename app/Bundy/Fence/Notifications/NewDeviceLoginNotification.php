<?php

namespace App\Bundy\Fence\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDeviceLoginNotification extends Notification
{
    use Queueable;

    public $for;

    public $user;

    public $location;

    public $identity;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($for, $user, $identity)
    {
        $this->for = $for;
        $this->user = $user;
        $this->identity = $identity;
        $this->location = geoip($identity['ip']);
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(__('messages.notification.new_device_login.subject'))
                    ->greeting(__("messages.notification.new_device_login.greeting.{$this->for}"), [
                        'name' => $this->user->first_name
                    ])
                    ->line(__("messages.notification.new_device_login.message.{$this->for}", [
                        // 
                    ]));
    }

    public function asType()
    {
        return 'new_device_login';
    }

    public function toPayload()
    {
        return [
            'for' => $this->for,
            'location' => $this->location,
            'identity' => $this->identity,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'username' => $this->user->username,
            ]
        ];
    }
}
