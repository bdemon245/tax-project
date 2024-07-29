<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use MailerSend\Helpers\Builder\Variable;
use MailerSend\LaravelDriver\MailerSendTrait;

class TestMail extends Mailable {
    use Queueable;
    use SerializesModels;
    use MailerSendTrait;

    /**
     * Create a new message instance.
     */
    public function __construct() {
    }

    public function build() {
        $variables = [
            new Variable('mojahid@wisedev.xyz', [
                'support_email' => '',
            ]),
        ];

        return $this
            ->mailersend('v69oxl5v17r4785k', $variables);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope {
        return new Envelope(
            subject: 'Test Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array {
        return [];
    }
}
