<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationNotification extends Notification
{
    use Queueable;

    protected string $username;

    /**
     * Create a new notification instance.
     *
     * @param string $username
     */
    public function __construct(string $username)
    {
        $this->username = $username;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Welcome, ' . $this->username . '!')
            ->line('Thank you for registering on our platform.')
            ->action('Visit Dashboard', url('/dashboard'))
            ->line('We are excited to have you on board!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'username' => $this->username,
            'message' => 'Thank you for registering on our platform.',
        ];
    }
}
