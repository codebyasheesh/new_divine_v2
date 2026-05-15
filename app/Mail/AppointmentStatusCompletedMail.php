<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentStatusCompletedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $booking;
    public $status;
    protected $bccEmails;
    /**
     * Create a new message instance.
     */
    public function __construct($booking, $status, $bccEmails=NULL)
    {
        $this->booking = $booking;
        $this->status = $status;
        $this->bccEmails = $bccEmails;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your appointment with Divine Touch is '.$this->status,
            bcc: [
                new Address($this->bccEmails)
            ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.appointment-status-completed',
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
