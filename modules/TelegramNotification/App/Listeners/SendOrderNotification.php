<?php

namespace Modules\TelegramNotification\App\Listeners;

use Illuminate\Support\Facades\Mail;
use Modules\Feedback\App\Events\FeedbackCreated;
use Modules\Feedback\App\Mail\FeedbackNotification;
use Modules\Shop\App\Events\OrderCreated;
use Modules\TelegramNotification\App\Services\Telegram;

class SendOrderNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        if (settings('active', group: 'telegram')) {
            $text = view('telegram-notification::shop-order', [
                'order' => $event->order,
            ])->render();
            $telegramService = new Telegram();
            $telegramService->sendNotifications($text);
        }
    }
}
