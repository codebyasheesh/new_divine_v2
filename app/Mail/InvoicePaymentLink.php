<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoicePaymentLink extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $paymentLink;
    public $amount;
    public $template_data;
    public $setting;
    public $template_content;
    /**
     * Create a new message instance.
     */
    public function __construct($data, $paymentLink, $amount)
    {
        $this->data = $data;
        $this->paymentLink = $paymentLink;
        $this->amount = $amount;
        $this->setting = getSetting();
        $this->template_data = EmailTemplate::where('template_key', 'invoice_payment_link')->where('status', 1)->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->template_data->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $lastspace = strrpos($this->data->customer_name, ' ');
        $first_name = substr($this->data->customer_name, 0, $lastspace);
        $placeholder = [
            '{{user}}' => ucwords($first_name),
            '{{invoice_date}}' => get_formatted_date($this->data->invoice_date, 'F d, Y'),
            '{{duration}}'  => $this->data->service_details[0]->duration,
            '{{pending_amount}}' => number_format($this->amount / 100, 2),
            '{{payment_link}}' => $this->paymentLink,
            '{{company_name}}' => $this->setting->company_name
        ];
        $this->template_content = str_replace(array_keys($placeholder), array_values($placeholder), $this->template_data->body);
        return new Content(
            markdown: 'emails.invoice_payment_link',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(
                fn() => Pdf::loadView('pdf.invoice-payment-link', ['data' => $this->data, 'payment_link' => $this->paymentLink])->output(), 'invoice.pdf'
            )->withMime('application/pdf'),
        ];
    }
}
