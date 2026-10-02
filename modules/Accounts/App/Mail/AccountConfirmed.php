<?php

namespace Modules\Accounts\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\{Address, Content, Envelope};
use Illuminate\Queue\SerializesModels;
use Modules\Accounts\App\Models\Account;

class AccountConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $account;
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.mailers.smtp.username'), settings('site_name', default: config('app.name'))),
            subject: 'Ваш аккаунт был подтвержден',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'accounts::emails.confirmed',
            with: [
                'account' => $this->account,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
