<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\ContactSubmission;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactSubmission $submission)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouveau message depuis le formulaire de contact',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-form-submitted',
        );
    }
} 