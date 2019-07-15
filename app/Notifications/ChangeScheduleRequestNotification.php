<?php

namespace App\Notifications;

use App\ScheduleRequest;
use Illuminate\Bus\Queueable;
use App\Bundy\NotificationSchema;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ChangeScheduleRequestNotification extends Notification
{
    use Queueable;

    public $request;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ScheduleRequest $request)
    {
        $this->request = $request;
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
                    ->from($this->request->user->email, $this->request->user->name)
                    ->subject('I would like to change my schedule')
                    ->line($this->request->user->name . ' wants to change his/her schedule!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return (new NotificationSchema)
                    ->make('change_schedule_request')
                    ->with($this->payload());
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
        return (new NotificationSchema)
                    ->make('change_schedule_request')
                    ->with([
                        'id' => $this->request->id,
                        'to' => $this->request->to,
                        'from' => $this->request->from,
                        'user' => [
                            'id' => $this->request->user->id,
                            'name' => $this->request->user->name,
                            'username' => $this->request->user->username,
                        ]
                    ]);
    }
}
