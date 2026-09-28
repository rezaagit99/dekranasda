<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusAccountUpdated extends Notification
{
    use Queueable;

    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function via($object)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('Pembaruan Status Akun - Dekranasda Kabupaten Tuban');

        if ($this->status === 'terverifikasi') {
            $mail->greeting('Halo, ' . $notifiable->name . '!')
                ->line('Selamat! Akun UMKM Anda telah berhasil **diverifikasi** oleh Admin Dekranasda Kabupaten Tuban.')
                ->line('Sekarang Anda sudah dapat masuk ke sistem untuk mengelola data UMKM dan produk Anda.')
                ->action('Masuk ke Akun Saya', route('login'))
                ->line('Terima kasih telah berpartisipasi dalam memajukan UMKM Kabupaten Tuban.');
        } elseif ($this->status === 'ditolak') {
            $mail->greeting('Halo, ' . $notifiable->name . '!')
                ->line('Mohon maaf, permohonan pendaftaran akun UMKM Anda **belum dapat kami setujui** saat ini.')
                ->line('Silakan hubungi tim Admin Dekranasda Kabupaten Tuban untuk informasi lebih lanjut mengenai kelengkapan berkas/data.');
        } else {
            $mail->greeting('Halo, ' . $notifiable->name . '!')
                ->line('Status akun Anda telah diperbarui menjadi: **' . ucfirst($this->status) . '**.');
        }
        $mail->salutation('Hormat kami, ' . config('app.name'));
        return $mail;
    }
}
