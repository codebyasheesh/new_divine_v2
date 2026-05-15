<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendMedicalFormMail extends Mailable
{
    use Queueable, SerializesModels;
    public $customer;
    public $formUrl;
    public $setting;
    public $parsed_text;
    public $template_data;
    /**
     * Create a new message instance.
     */
    public function __construct($customer, $formUrl)
    {
        $this->customer = $customer;
        $this->formUrl = $formUrl;
        $this->setting = getSetting();
        $this->template_data = EmailTemplate::where('template_key', 'send_medical_form')->where('status', 1)->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->template_data->subject,
            replyTo: [
                new Address('info@divinetouchtherapy.com', $this->setting->company_name)
            ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $body = $this->template_data->body;
        $lastspace = strrpos($this->customer, ' ');
        $first_name = substr($this->customer, 0, $lastspace);
        $placeholders = [
            '{{user}}' => $first_name,
            '{{formUrl}}' => $this->formUrl,
            '{{company_name}}' => $this->setting->company_name,
            '{{formUrl_button}}' => '<a href="'.$this->formUrl.'" style="background-color: #198754; color: #FFF; border-color: #198754; padding: .375rem .75rem; border-radius:0.25rem; font-size:1rem; text-decoration:none;">Patient Intake & Health Form</a>'
        ];

        $this->parsed_text = str_replace(array_keys($placeholders), array_values($placeholders), $body);
        return new Content(
            markdown: 'emails.medical-form',
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
