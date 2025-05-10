<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LogoutNotification extends Notification
{
    use Queueable;

    protected string $username;
    protected string $logoutTime;

    /**
     * Create a new notification instance.
     *
     * @param string $username
     * @param string $logoutTime
     */
    public function __construct(string $username, string $logoutTime)
    {
        $this->username = $username;
        $this->logoutTime = $logoutTime;
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
            ->greeting('Goodbye, ' . $this->username . '!')
            ->line('You have successfully logged out at ' . $this->logoutTime . '.')
            ->line('We hope to see you again soon!')
            ->action('Visit Us Again', url('/'))
            ->line('Thank you for using our application!');
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
            'logout_time' => $this->logoutTime,
        ];
    }
}
