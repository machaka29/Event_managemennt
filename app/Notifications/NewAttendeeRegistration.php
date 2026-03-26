<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAttendeeRegistration extends Notification
{
    use Queueable;

    protected $attendee;
    protected $event;

    /**
     * Create a new notification instance.
     */
    public function __construct($attendee, $event)
    {
        $this->attendee = $attendee;
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('A new attendee has registered for your event.')
            ->line('Attendee: ' . $this->attendee->full_name)
            ->line('Event: ' . $this->event->title)
            ->action('View Registrations', url('/admin/registrations'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'attendee_name' => $this->attendee->full_name,
            'attendee_id' => $this->attendee->id,
            'event_title' => $this->event->title,
            'event_id' => $this->event->id,
            'message' => 'New member registered: ' . $this->attendee->full_name,
        ];
    }
}
