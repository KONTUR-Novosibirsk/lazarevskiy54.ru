<?php

namespace Modules\TelegramNotification\App\Listeners;

use Illuminate\Support\Facades\Mail;
use Modules\Feedback\App\Events\FeedbackCreated;
use Modules\Feedback\App\Mail\FeedbackNotification;
use Modules\TelegramNotification\App\Services\Telegram;

class SendFeedbackNotification
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
    public function handle(FeedbackCreated $event): void
    {
        if (settings('active', group: 'telegram')) {
            $text = view('telegram-notification::feedback', [
                'feedback' => $event->feedback,
                'labels' => $event->feedback->getConfig()['form'],
            ])->render();
            $telegramService = new Telegram();
            $telegramService->sendNotifications($text);
        }
    }
}
