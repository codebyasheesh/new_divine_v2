<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MedicalFormPdfMail extends Mailable
{
    use Queueable, SerializesModels;
    public $customer_name;
    public $filename;
    public $pdf;
    /**
     * Create a new message instance.
     */
    public function __construct($customer_name, $filename, $pdf)
    {
        $this->customer_name = $customer_name;
        $this->filename = $filename;
        $this->pdf = $pdf;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Patient Intake Form - '.$this->customer_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.medical-form-pdf-generate',
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
            Attachment::fromPath($this->pdf)->as($this->filename)->withMime('application/pdf'),
        ];
    }
}
