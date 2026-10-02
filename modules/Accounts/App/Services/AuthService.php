<?php


namespace Modules\Accounts\App\Services;

use Modules\Accounts\App\Models\Account;

class AuthService
{
    public function attemptLogin(array $data): ?Account
    {
        $account = Account::query()->firstWhere('login', $data['login']);
        if (!$account || !$account->checkPassword($data['password'])) {
            return null;
        }
        return $account->login($data['remember'] ?? false);
    }
}
