<?php

namespace App\Notifications;

use App\ScheduleRequest;
use Illuminate\Bus\Queueable;
use App\Bundy\NotificationStub;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ChangeScheduleRequestNotification extends Notification
{
    use Queueable, NotificationStub;

    public $scheduleRequest;

    public function __construct(ScheduleRequest $scheduleRequest)
    {
        $this->scheduleRequest = $scheduleRequest;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Howdy Admins,')
                    ->from($this->scheduleRequest->user->email, $this->scheduleRequest->user->name)
                    ->subject(__('messages.notification.schedule_request.subject.new', [
                        'request' => 'change schedule request'
                    ]))
                    ->line(__('messages.notification.schedule_request.message.new', [
                        'request' => 'change schedule request',
                        'name' => $this->scheduleRequest->user->name,
                        'reason' => $this->scheduleRequest->reason
                    ]));
    }

    public function asType()
    {
        return 'change_schedule_request';
    }

    public function toPayload()
    {
        return [
            'id' => $this->scheduleRequest->id,
            'to' => $this->scheduleRequest->to,
            'from' => $this->scheduleRequest->from,
            'user' => [
                'id' => $this->scheduleRequest->user->id,
                'name' => $this->scheduleRequest->user->name,
                'username' => $this->scheduleRequest->user->username,
            ]
        ];
    }
}
