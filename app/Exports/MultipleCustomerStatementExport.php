<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MultipleCustomerStatementExport implements FromCollection, WithHeadings
{
    protected $data;

    /**
     * Create Constructor
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $report = collect();
        foreach($this->data as $val) {
            $paid_amt = ($val->payment()->count() > 0) ? $val->payment->paid_amount : 0;
            $credit_amt = ($val->payment()->count() > 0) ? $paid_amt - $val->hst_tax : 0;
            $report->push([
                'Invoice Date' => get_formatted_date($val->invoice_date, 'M d, Y'),
                'Name' => $val->customer_name,
                'Billed' => number_format($val->final_amount, 2),
                'Tax' => number_format($val->hst_tax, 2),
                'Received' => number_format($paid_amt, 2),
                'Credit' => number_format($credit_amt, 2),
                'Charge' => ''
            ]);
        }
        return $report;
    }

    public function headings(): array
    {
        return [
            'Invoice Date',
            'Name',
            'Billed',
            'Tax',
            'Received',
            'Credit',
            'Charge'
        ];
    }
}
