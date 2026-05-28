<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AuthCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $code,
    )
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Код для потверждения голоса',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.auth-code-mail',
        );
    }
}
