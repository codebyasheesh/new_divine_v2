<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentStatusCanceledMail extends Mailable
{
    use Queueable, SerializesModels;
    public $booking;
    public $status;
    public $template_data;
    public $template_content;
    public $setting;
    /**
     * Create a new message instance.
     */
    public function __construct($booking, $status)
    {
        $this->booking = $booking;
        $this->status = $status;
        $this->setting = getSetting();
        $this->template_data = EmailTemplate::where('template_key', 'appointment_canceled')->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->template_data->subject
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $lastSpace = strrpos($this->booking->customer_name, ' ');
        $first_name = substr($this->booking->customer_name, 0, $lastSpace);
        $placeholders = [
            '{{user}}' => $first_name,
            '{{parent_service_name}}' => $this->booking->parent_service_name,
            '{{booking_date}}' => get_formatted_date($this->booking->booking_date, 'F d, Y'),
            '{{time}}'          => explode(',', $this->booking->time_slots)[0],
            '{{company_name}}' => $this->setting->company_name
        ];
        $this->template_content = str_replace(array_keys($placeholders), array_values($placeholders), $this->template_data->body);
        return new Content(
            markdown: 'emails.appointment-status-canceled',
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
