<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginNotification extends Notification
{
    use Queueable;

    protected $username;
    protected $loginTime;

    /**
     * Create a new notification instance.
     *
     * @param string $username
     * @param string $loginTime
     */
    public function __construct(string $username, string $loginTime)
    {
        $this->username = $username;
        $this->loginTime = $loginTime;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->greeting('Hello, ' . $this->username . '!')
                    ->line('Kamu telah berhasil login pada ' . $this->loginTime . '.')
                    ->action('Dashboard', url('/dashboard'))
                    ->line('Terima kasih!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'username' => $this->username,
            'message' => "Kamu telah berhasil login!"// Pastikan key 'message' ada
        ];
    }
}
