<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $template_content;
    // protected $ccEmails;
    // protected $bccEmails;
    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        $template = EmailTemplate::where('template_key', 'invoice_email')->where('status', 1)->first();

        $body = $template->body;

        $placeholders = [
            '{{user}}' => $this->data->user_dtl->first_name,
            '{{appointment_date}}' => get_formatted_date($this->data->invoice_date, 'F d, Y'),
            '{{duration}}' => $this->data->service_details[0]->duration
        ];

        $this->template_content = str_replace(array_keys($placeholders), array_values($placeholders), $body);

        $pdf = Pdf::loadView('pdf.invoice', ['data' => $this->data]);

        return $this->subject('Your RMT Invoice - Divine Touch Therapy')
                    ->markdown('emails.invoice')
                    ->attachData($pdf->output(), 'inv_'.$this->data->invoice_number.'.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }

}
