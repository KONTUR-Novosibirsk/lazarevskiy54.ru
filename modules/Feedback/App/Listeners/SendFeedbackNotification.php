<?php

namespace Modules\Feedback\App\Listeners;

use Illuminate\Support\Facades\Mail;
use Modules\Feedback\App\Events\FeedbackCreated;
use Modules\Feedback\App\Mail\FeedbackNotification;

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
        if (settings('email')) {
            Mail::to(settings('email'))->send(new FeedbackNotification($event->feedback));
        }
    }
}
