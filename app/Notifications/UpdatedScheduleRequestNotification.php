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
                    ->subject($this->resolveSubject())
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'));
    }
    
    private function resolveSubject()
    {
        if ($this->scheduleRequest->approved === $this->scheduleRequest::APPROVED) {
            return 'Change schedule request has been declined';
        }
        
        return 'Change schedule request has been approved';
    }

    public function asType()
    {
        if ($this->scheduleRequest->approved === $this->scheduleRequest::APPROVED) {
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
