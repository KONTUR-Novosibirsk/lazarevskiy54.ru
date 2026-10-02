<?php

namespace Modules\Shop\App\Listeners;

use Illuminate\Support\Facades\Mail;
use Modules\Shop\App\Events\OrderCreated;
use Modules\Shop\App\Mail\OrderAdminNotification;
use Modules\Shop\App\Mail\OrderNotification;

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
        if (settings('email')) {
            Mail::to(settings('email'))->send(new OrderAdminNotification($event->order));
        }
        if ($event->order->user_email) {
            Mail::to($event->order->user_email)->send(new OrderNotification($event->order));
        }
    }
}
