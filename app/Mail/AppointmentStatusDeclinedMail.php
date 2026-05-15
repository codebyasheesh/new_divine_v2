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

class AppointmentStatusDeclinedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $booking;
    public $status;
    public $medical_form_link;
    public $template_content;
    public $template_data;
    public $setting;
    /**
     * Create a new message instance.
     */
    public function __construct($booking, $status, $medical_form_link)
    {
        $this->booking = $booking;
        $this->status = $status;
        $this->medical_form_link = $medical_form_link;
        $this->template_data = EmailTemplate::where('template_key', 'appointment_declined')->first();
        $this->setting = getSetting();
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
        $placeholder = [
            '{{user}}' => $first_name,
            '{{parent_service_name}}' => $this->booking->parent_service_name,
            '{{booking_date}}' => get_formatted_date($this->booking->booking_date, 'F d, Y'),
            '{{company_name}}' => $this->setting->company_name
        ];
        $this->template_content = str_replace(array_keys($placeholder), array_values($placeholder), $this->template_data->body);
        return new Content(
            markdown: 'emails.appointment-status-declined',
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
