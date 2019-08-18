<?php

namespace App\Notifications;

use App\Bundy\NotificationSchema;
use App\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class LeaveRequestNotification extends Notification
{
    use Queueable;

    public $leave;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Leave $leave)
    {
        $this->leave = $leave;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'broadcast', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from($this->leave->user->email, $this->leave->user->name)
                    ->subject(__('messages.notification.request.subject', [
                        'request' => 'leave request'
                    ]))
                    ->line(__('messages.notification.request.message', [
                        'request' => 'leave request',
                        'name' => $this->leave->user->name
                    ]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->payload();
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->payload());
    }

    public function payload()
    {
        return (new NotificationSchema('leave_request'))
                    ->with([
                        'id' => $this->leave->id,
                        'ends_on' => $this->leave->ends_on,
                        'starts_on' => $this->leave->starts_on,
                        'user' => [
                            'id' => $this->leave->user->id,
                            'name' => $this->leave->user->name,
                            'username' => $this->leave->user->username,
                        ]
                    ]);
    }
}
