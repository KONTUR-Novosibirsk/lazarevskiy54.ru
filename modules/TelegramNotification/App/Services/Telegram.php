<?php

namespace Modules\TelegramNotification\App\Services;

use Illuminate\Support\Facades\Http;
use Modules\TelegramNotification\App\Models\TelegramAccount;

class Telegram
{
    protected ?string $apiUrl = null;

    public function __construct()
    {
        if (settings('token', group: 'telegram'))
            $this->apiUrl = 'https://api.telegram.org/bot' . settings('token', group: 'telegram');
    }

    public function sendNotifications(string $text): void
    {
        $telegramAccounts = TelegramAccount::query()->where('is_active', true)->get();
        foreach ($telegramAccounts as $account) {
            $this->sendMessage($account->chat_id, $text);
        }
    }

    public function sendMessage(int $chat_id, string $text): bool|\Illuminate\Http\Client\Response
    {
        if ($this->apiUrl) {
            $response = Http::post($this->apiUrl . '/sendMessage', [
                'parse_mode' => 'HTML',
                'chat_id' => $chat_id,
                'text' => $text,
            ]);
            $response = json_decode($response->body());
            return $response->ok;
        }

        return false;
    }

}
