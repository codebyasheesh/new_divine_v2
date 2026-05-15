<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerStatementMail extends Mailable
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
        $this->data             = $data;
        $this->start_dt         = $start_dt;
        $this->end_dt           = $end_dt;
        $this->pdf              = $pdf;
        $this->customer_name    = $data[0]->customer_name;
        $this->template_data    = EmailTemplate::where('template_key', 'customer_statement')->where('status', 1)->first();
        $this->setting          = getSetting();
    }


    public function build()
    {
        $lastspace = strrpos($this->customer_name, ' ');
        $first_name = substr($this->customer_name, 0, $lastspace);
        $placeholder = [
            '{{user}}' => ucwords($first_name),
            '{{start_date}}' => get_formatted_date($this->start_dt, 'M d, Y'),
            '{{end_date}}' => get_formatted_date($this->end_dt, 'M d, Y'),
            '{{company_name}}' => $this->setting->company_name
        ];
        $this->template_content = str_replace(array_keys($placeholder), array_values($placeholder), $this->template_data->body);
        return $this->subject($this->template_data->subject)
            ->markdown('emails.customer_statement')
            ->attachData($this->pdf->output(), 'Customer-Statement.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
