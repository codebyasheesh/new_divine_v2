<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Attachable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $booking;
    public $medical_frm_lnk;
    // public $icsPath;
    
    /**
     * Create a new message instance.
     */
    public function __construct($booking, $medical_frm_lnk)
    {
        $this->booking = $booking;
        // $this->icsPath = $icsPath;
        $this->medical_frm_lnk = $medical_frm_lnk;
    }



    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your appointment with Divine Touch is confirmed.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking_confirmed',
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
            // Attachment::fromPath($this->icsPath)
            // ->as('appointment_'.$this->booking->id.'.ics')
            // ->withMime('text/calendar; method=REQUEST; charset=UTF-8'),
        ];
    }
}
