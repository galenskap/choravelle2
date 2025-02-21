<?php

namespace App\Mail;

use App\Models\ContactSubmission;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewContactSubmission extends Mailable
{
    use SerializesModels;

    public $submission;

    public function __construct(ContactSubmission $submission)
    {
        $this->submission = $submission;
    }

    public function build()
    {
        return $this->markdown('emails.contact-submission')
                    ->subject('Nouveau message de contact');
    }
} 