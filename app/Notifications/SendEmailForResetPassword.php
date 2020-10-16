<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class SendEmailForResetPassword extends ResetPassword
{
    public function toMail($notifiable)
    {
        $url = config('app.url_client') . "/reset/password/" . $this->token . "?email=" . urlencode($notifiable->email);
        $user = User::whereEmail($notifiable->email)->first();
        return (new MailMessage)
            ->markdown('emails.passwords.reset', [
                "user" => $user,
                "url" => $url
            ])
            ->subject(Lang::get('Restablecer contraseña'));
    }
}
