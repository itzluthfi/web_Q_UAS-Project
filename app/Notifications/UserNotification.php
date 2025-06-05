<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserNotification extends Notification
{
    use Queueable;

    protected $pesan;

    public function __construct($pesan)
    {
        $this->pesan = $pesan;
    }

    // Channel notifikasi: mail (email)
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    // Isi email yang dikirim
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Notifikasi Login')
        ->view('email.loginNotification', ['user' => $notifiable]);
    }
}
