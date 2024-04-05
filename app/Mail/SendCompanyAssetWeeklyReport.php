<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Fluent;

class SendCompanyAssetWeeklyReport extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct(public readonly Company $company, public readonly Fluent $report)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Company Asset Weekly Report',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.company.weekly_asset_summary',
            with: [
                'report' => $this->report,
                'company' => $this->company
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
