<?php

namespace App\Notifications;

use App\Models\Pengiriman;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusUpdatedNotification extends Notification
{
    use Queueable;
    public $pengiriman;
    /**
     * Create a new notification instance.
     */
    public function __construct(Pengiriman $pengiriman)
    {
        //
        $this->pengiriman = $pengiriman;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Status Pengiriman Anda Diperbarui')
            ->greeting('Halo,')
            ->line("Nomor Resi: {$this->pengiriman->no_resi}")
            ->line("Status terbaru: {$this->pengiriman->status}")
            ->line("Lokasi terakhir: {$this->pengiriman->lokasi_terakhir}")
            ->line('Silakan cek kembali halaman pelacakan untuk info lengkap.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
