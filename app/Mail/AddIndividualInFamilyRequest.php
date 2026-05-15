<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AddIndividualInFamilyRequest extends Mailable
{
    use Queueable, SerializesModels;
    public $final_data;

    /**
     * Create a new message instance.
     */
    public function __construct($final_data)
    {
        $this->final_data = $final_data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $full_name = ($this->final_data['parent_last_name'])? $this->final_data['parent_last_name'].', '.$this->final_data['parent_first_name'] : $this->final_data['parent_first_name'];

        return new Envelope(
            subject: 'Request for Add Individual In Family by '.$full_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.addindividualinfamilytemplate',
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
