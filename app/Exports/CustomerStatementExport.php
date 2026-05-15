<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerStatementExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $name;
    protected $mobile;

    public function __construct($data, $name, $mobile)
    {
        $this->data = $data;
        $this->name = $name;
        $this->mobile = $mobile;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $report = collect();
        foreach($this->data as $val) {
            $report->push([
                'Invoice Date' => get_formatted_date($val->invoice_date, 'M d, Y'),
                'Name' => $this->name,
                'Billed' => number_format($val->final_amount, 2),
                'Tax' => number_format($val->hst_tax, 2),
                'Received' => ($val->payment()->count() > 0) ? number_format($val->payment->paid_amount, 2) : '0',
                'Credit' => ($val->payment()->count() > 0) ? number_format($val->payment->paid_amount - $val->hst_tax, 2) : '0',
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
