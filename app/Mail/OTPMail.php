<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OTPMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $otp,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Rayda verification code',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user.otp',
            with: [
                'user' => $this->user,
                'otp' => $this->otp,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

