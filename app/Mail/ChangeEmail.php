<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChangeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationLink;

    public function __construct($user, $verificationLink)
    {
        $this->user = $user;
        $this->verificationLink = $verificationLink;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Change Verification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.change_email',
            with: [
                'user' => $this->user,
                'link' => $this->verificationLink,
            ]
        );
    }
}
