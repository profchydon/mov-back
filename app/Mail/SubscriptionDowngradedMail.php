<?php

namespace App\Mail;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionDowngradedMail extends Mailable
{
    private $company;
    private $oldPlan;
    private $newPlan;
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
        $this->oldPlan = $data['oldPlan'];
        $this->newPlan = $data['newPlan'];
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
            subject: 'Subscription Ended!',
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
            view: 'emails.subscription.subscription-downgraded',
            with: [
                'company' => $this->company,
                'oldPlan' => $this->oldPlan,
                'newPlan' => $this->newPlan,
                'offers' => $this->offers,
                'offersLost' => array_diff($this->oldPlan->offers, $this->newPlan->offers),
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
