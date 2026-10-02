<?php

namespace Modules\Shop\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\Feedback\App\Models\Feedback;
use Modules\Shop\App\Models\ShopOrder;

class OrderAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected ShopOrder $order;

    /**
     * Create a new message instance.
     */
    public function __construct(ShopOrder $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.mailers.smtp.username'), settings('site_name', default: config('app.name'))),
            subject: 'Новый заказ на сайте  - ' . settings('site_name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'shop::emails.order.admin-notification',
            with: [
                'order' => $this->order,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
