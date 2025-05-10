<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderApprovedNotification extends Notification
{
    use Queueable;

    private $order;
    private $event;

    /**
     * Create a new notification instance.
     *
     * @param Order $order
     */
    public function __construct($order, $event)
    {
        $this->order = $order;
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array<string>
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Order Approved')
            ->line('Orderan tiket pada event' . ($this->event->name ?? 'N/A') . ' sudah di approve!')
            ->line('Total Price: Rp ' . number_format($this->order->total_price ?? 0, 0, ',', '.'))
            ->action('View Order', url('/orders/' . ($this->order->id_order ?? '#')))
            ->line('Thank you for using our platform!');
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @param mixed $notifiable
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id_order ?? null,
            'message' => 'Orderan tiket pada event ' . ($this->event->name ?? 'N/A') . ' sudah di approve!',
            'total_price' => $this->order->total_price ?? 0,
            'status' => $this->order->status ?? 'unknown',
        ];
    }
}
