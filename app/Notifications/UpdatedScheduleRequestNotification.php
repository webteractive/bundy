<?php

namespace App\Notifications;

use App\ScheduleRequest;
use Illuminate\Bus\Queueable;
use App\Bundy\NotificationStub;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UpdatedScheduleRequestNotification extends Notification
{
    use Queueable, NotificationStub;

    public $scheduleRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ScheduleRequest $scheduleRequest)
    {
        $this->scheduleRequest = $scheduleRequest;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting("Hi {$this->scheduleRequest->user->first_name},")
                    ->subject(__('messages.notification.schedule_request.subject.' . ($this->scheduleRequest->isApproved() ? 'approved' : 'rejected')))
                    ->line(__('messages.notification.schedule_request.message.updated',  [
                        'date' => $this->scheduleRequest->created_at->format('L, F d, Y \a\r\o\u\n\d h:i A'),
                        'status' => $this->scheduleRequest->isApproved() ? 'approved' : 'rejected',
                        'reason' => is_null($this->scheduleRequest->action_reason) || empty($this->scheduleRequest->action_reason) ? '' : (' With reason' .  $this->scheduleRequest->action_reason)
                    ]));
    }

    public function asType()
    {
        if ($this->scheduleRequest->isApproved()) {
            return 'change_schedule_request_approved';
        }
        
        return 'change_schedule_request_disapproved';
    }

    public function toPayload()
    {
        return [
            'id' => $this->scheduleRequest->id,
            'to' => $this->scheduleRequest->to,
            'from' => $this->scheduleRequest->from,
            'approved' => $this->scheduleRequest->approved,
            'action_reason' => $this->scheduleRequest->action_reason,
            'user' => [
                'id' => $this->scheduleRequest->user->id,
                'name' => $this->scheduleRequest->user->name,
                'username' => $this->scheduleRequest->user->username,
            ]
        ];
    }
}
