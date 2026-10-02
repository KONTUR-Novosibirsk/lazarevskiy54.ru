<?php

namespace Modules\Accounts\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class PasswordReset extends Notification
{
    use Queueable;

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
        $url = url(route('account.password.edit', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->greeting('Здравствуйте!')
            ->subject(Lang::get('Уведомление о сбросе пароля'))
            ->line(Lang::get('Ссылка для сброса пароля будет активна в течение :count минут.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('Если вы не запрашивали сброс пароля, просто проигнорируйте это письмо.'))
            ->action(Lang::get('Сбросить пароль'), $url)
            ->salutation('С уважением, '. settings('site_name', default: config('app.name')));
    }
}
