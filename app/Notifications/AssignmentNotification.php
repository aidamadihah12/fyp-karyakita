<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Booking;

class AssignmentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $booking;

    // ✅ Constructor that accepts Booking
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('You have been assigned a new booking')
            ->greeting('Hello ' . $notifiable->name)
            ->line('You have been assigned to a new event.')
            ->line('Event Date: ' . $this->booking->event_date)
            ->line('Booking ID: ' . $this->booking->id)
            ->action('View Assignment', url('/freelance/assignments'))
            ->line('Thank you for your dedication!');
    }
}
