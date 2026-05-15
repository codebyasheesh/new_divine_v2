<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RescheduleAppointmentMail extends Mailable
{
    use Queueable, SerializesModels;
    public $booking;
    public $template_data;
    public $mail_body;
    public $setting;
    public $body_text;
    /**
     * Create a new message instance.
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
        $this->setting = getSetting();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if($this->booking->parent_ids[0] == 1){
            $this->template_data = EmailTemplate::where('template_key', 'rmt_re-schedule_appointment')->where('status', 1)->first();
            $subject = $this->template_data->subject;
            $this->mail_body = $this->template_data->body;
        }
        else {
            $this->template_data = EmailTemplate::where('template_key', 'rmt_re-schedule_appointment')->where('status', 1)->first();
            $subject = $this->template_data->subject;
            $this->mail_body = $this->template_data->body;
        }
        return new Envelope(
            subject: $subject
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $lastspace = strpos($this->booking->customer_name, ' ');
        $first_name = substr($this->booking->customer_name, 0, $lastspace);
        if($this->booking->parent_ids[0] == 1) {
            $service = 'RMT Massage Therapy';
        }
        else {
            $service = $this->booking->parent_service_name;
        }
        $placeholder = [
            '{{user}}' => ucwords($first_name),
            '{{service}}' => $service,
            '{{booking_date}}' => get_formatted_date($this->booking->booking_date, 'F d, Y'),
            '{{time}}' => explode(',', $this->booking->time_slots)[0],
            '{{duration}}' => $this->booking->duration[0],
            '{{company_name}}' => $this->setting->company_name
        ];
        $this->body_text = str_replace(array_keys($placeholder), array_values($placeholder), $this->mail_body);
        return new Content(
            markdown: 'emails.reschedule-appointment',
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
