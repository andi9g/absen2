<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
  public $token;

  public function __construct($token)
  {
    $this->token = $token;
  }

  public function via($notifiable)
  {
    return ['mail'];
  }

  public function toMail($notifiable)
  {
    $resetUrl = url(route('password.reset', ['token' => $this->token, 'email' => $notifiable->email], false));

    return (new MailMessage)
      ->subject('Reset Password Akunmu')
      ->greeting('Halo, ' . $notifiable->name . '!')
      ->line('Kami menerima permintaan reset password untuk akunmu.')
      ->action('Reset Password', $resetUrl)
      ->line('Jika kamu tidak meminta reset password, abaikan email ini.');
  }
}
