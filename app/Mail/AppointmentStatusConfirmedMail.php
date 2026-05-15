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

class AppointmentStatusConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $booking;
    public $medical_link;
    public $template_data;
    public $template_content;
    public $setting;

    /**
     * Create a new message instance.
     */
    public function __construct($booking, $medical_link=NULL)
    {
        $this->booking = $booking;
        $this->medical_link = $medical_link;
        $this->setting = getSetting();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if($this->booking->parent_ids[0] == 1){
            $this->template_data = EmailTemplate::where('template_key', 'rmt_appointment_confirmation')->where('status', 1)->first();
            $subject = $this->template_data->subject;
        }
        else {
            $this->template_data = EmailTemplate::where('template_key', 'other_rmt_appointment_confirmed')->where('status', 1)->first();
            $subject = $this->template_data->subject;
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
        // if($this->booking->parent_service_name == '')
        if($this->booking->parent_ids[0] == 1){
            $this->template_data = EmailTemplate::where('template_key', 'rmt_appointment_confirmation')->where('status', 1)->first();
            $lastspace = strpos($this->booking->customer_name, ' ');
            $first_name = substr($this->booking->customer_name, 0, $lastspace);

            $placeholders = [
                '{{user}}'          => $first_name,
                '{{booking_date}}'  => get_formatted_date($this->booking->booking_date, 'F d, Y'),
                '{{time}}'          => explode(',', $this->booking->time_slots)[0],
                '{{duration}}'      => $this->booking->duration[0],
                '{{medical_link}}'  => $this->medical_link,
                '{{company_name}}'  => $this->setting->company_name
            ];

            $this->template_content = str_replace(array_keys($placeholders), array_values($placeholders), $this->template_data->body);
            $template = 'rmt-appointment-status-confirmed';
        }
        else {
            $this->template_data = EmailTemplate::where('template_key', 'other_rmt_appointment_confirmed')->where('status', 1)->first();
            $lastspace = strpos($this->booking->customer_name, ' ');
            $first_name = substr($this->booking->customer_name, 0, $lastspace);

            $placeholders = [
                '{{user}}'                  => $first_name,
                '{{parent_service_name}}'   => $this->booking->parent_service_name,
                '{{booking_date}}'  => get_formatted_date($this->booking->booking_date, 'F d, Y'),
                '{{time}}'          => explode(',', $this->booking->time_slots)[0],
                '{{company_name}}' => $this->setting->company_name
            ];
            $this->template_content = str_replace(array_keys($placeholders), array_values($placeholders), $this->template_data->body);
            $template = 'other-rmt-appointment-status-confirmed';
        } 
        return new Content(
            markdown: 'emails.'.$template,
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
