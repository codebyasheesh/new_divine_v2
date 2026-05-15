<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MultipleCustomerStatementMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $start_dt;
    public $end_dt;
    public $pdf;
    public $customer_name;
    public $template_data;
    public $template_content;
    public $setting;
    
    /**
     * Create a new message instance.
     */
    public function __construct($data, $start_dt, $end_dt, $pdf)
    {
        $this->data = $data;
        $this->start_dt = $start_dt;
        $this->end_dt   = $end_dt;
        $this->pdf      = $pdf;
        $this->customer_name = $data[0]->customer_name;
        $this->template_data = EmailTemplate::where('template_key', 'multiple_customer_statement')->first();
        $this->setting = getSetting();
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        $lastSpace = strrpos($this->customer_name, ' ');
        $first_name = substr($this->customer_name, 0, $lastSpace);
        $placeholder = [
            '{{user}}' => $first_name,
            '{{start_date}}' => get_formatted_date($this->start_dt, 'F d, Y'),
            '{{end_date}}' => get_formatted_date($this->end_dt, 'F d, Y'),
            '{{company_name}}' => $this->setting->company_name
        ];
        $this->template_content = str_replace(array_keys($placeholder), array_values($placeholder), $this->template_data->body);
        return $this->subject($this->template_data->subject)
            ->markdown('emails.multiple_customer_statement')
            ->attachData($this->pdf->output(), 'multiple-customer-statement.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
