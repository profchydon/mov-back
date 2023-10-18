<?php

namespace App\Mail;

use App\Models\UserInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CompanyUserInvitationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @param UserInvitation $dto
     */
    public function __construct(public UserInvitation $userInvitation)
    {

        Log::info(env('APP_FRONTEND_URL') . "/user-invitation/" . $this->userInvitation->code ."?email={$this->userInvitation->email}");

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Company Invitation'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.company.user_invitation',
            with: [
                'invitedBy' => $this->userInvitation->invitedBy->first_name,
                'company' => $this->userInvitation->company->name,
                'link' => env('APP_FRONTEND_URL') . "/user-invitation/" . $this->userInvitation->code ."?email={$this->userInvitation->email}",
                // 'link' => sprintf('%f/user-invitation/%f', env('FRONTEND_URL'), $this->userInvitation->code),
            ]
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
