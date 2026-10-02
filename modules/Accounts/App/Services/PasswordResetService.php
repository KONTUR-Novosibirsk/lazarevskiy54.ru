<?php


namespace Modules\Accounts\App\Services;

use Exception;
use Illuminate\Support\Facades\{Hash, Password};

class PasswordResetService
{
    public function sendResetLink(string $email): array
    {
        try {
            $status = Password::broker('accounts')->sendResetLink(['email' => $email]);
            if ($status === Password::RESET_LINK_SENT) {
                return ['message' => 'Ссылка для сброса пароля была отправлена на ваш email'];
            }
            return ['message' => 'Не удалось отправить ссылку для сброса пароля'];
        } catch (Exception $e){
            return ['message' => 'Такого email не существует'];
        }
    }

    public function update(array $data): void
    {
        Password::broker('accounts')->reset(
            ['email' => $data['email'], 'password' => $data['password'], 'token' => $data['token']],
            function ($account, $password) {
                $account->forceFill(['password' => Hash::make($password)])->save();
                $account->logout();
            }
        );
    }
}
