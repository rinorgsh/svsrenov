<?php

namespace App\Mail;

use App\Models\ContactRequest;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ContactRequestMail extends Mailable
{

    /**
     * Create a new message instance.
     */
    public function __construct(
        public ContactRequest $contactRequest
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $serviceName = $this->contactRequest->service?->title_fr ?? 'Non spécifié';

        return new Envelope(
            subject: "Nouvelle demande de devis - {$this->contactRequest->name}",
            replyTo: [$this->contactRequest->email],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-request',
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
