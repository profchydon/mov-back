<?php

namespace App\Mail;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionActivationMail extends Mailable
{
    private $company;
    private $plan;
    private $offers;
    private $invoice;
    private $invoiceItems;
    private $currency;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public array $data)
    {
        $this->company = $data['company'];
        $this->plan = $data['plan'];
        $this->offers = $data['offers'];
        $this->invoice = $data['invoice'] ?? null;
        $this->invoiceItems = $data['invoiceItems'] ?? null;
        $this->currency = $data['currency'] ?? null;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your subscription has been activated. 👍',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.subscription.subscription-activated',
            with: [
                'company' => $this->company,
                'plan' => $this->plan,
                'offers' => $this->offers,
                'invoice' => $this->invoice,
                'invoiceItems' => $this->invoiceItems,
                'currency' => $this->currency,
                'link' => env('APP_FRONTEND_URL') . '/dashboard/settings/billing',
            ],
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
