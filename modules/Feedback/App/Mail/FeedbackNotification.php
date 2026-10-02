<?php

namespace Modules\Feedback\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\{Address, Content, Envelope};
use Illuminate\Queue\SerializesModels;
use Modules\Feedback\App\Models\Feedback;

class FeedbackNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected Feedback $feedback;

    /**
     * Create a new message instance.
     */
    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.mailers.smtp.username'), settings('site_name', default: config('app.name'))),
            subject: 'Новое сообщение на сайте  - ' . settings('site_name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'feedback::emails.notification',
            with: [
                'feedback' => $this->feedback,
                'labels' => $this->feedback->getConfig()['form'],
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
