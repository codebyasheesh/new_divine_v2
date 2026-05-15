<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\CustomerStatementMail;
use App\Mail\MultipleCustomerStatementMail;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Exports\CustomerStatementExport;
use App\Exports\MultipleCustomerStatementExport;
use App\Exports\RevenueSummaryExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    // this function is used to Show Customer Statement.
    public function index()
    {
        return view('admin.report.index');
    }

    // Get Date Range and customer name and mobile to fetch the Booking details
    public function customerReport(Request $request)
    {
        $user_id = $request->id;

        if(!empty($request->direct_billing)) {
            $direct_bill = 0;
            $direct_bill_title = '';
        }
        else {
            $direct_bill = '';
            $direct_bill_title = '';
        }

        if(!empty($request->bank_payment)) {
            $bank_pay = 0;
            $bank_pay_title = '';
        }
        else {
            $bank_pay = '';
            $bank_pay_title = '';
        }

        if(!empty($request->cash)) {
            $cash = 0;
            $cash_title = '';
        }
        else {
            $cash = '';
            $cash_title = '';
        }

        if(!empty($request->other_method)) {
            $other_method = 0;
            $other_method_title = '';
        }
        else {
            $other_method = '';
            $other_method_title = '';
        }

        if(!empty($request->account)) {
            $account = 0;
            $account_title = '';
        }
        else {
            $account = '';
            $account_title = '';
        }

        $start_dt = get_formatted_date($request->start_dt, 'Y-m-d');
        $end_dt = get_formatted_date($request->end_dt, 'Y-m-d');

        $data = Invoice::with('payment')->whereDate('invoice_date', '>=', $start_dt)->whereDate('invoice_date', '<=', $end_dt)->where('customer_id', $user_id)->get();
        // pr($data);die;
        $report_detail = array();
        if(!empty($data)) {
            // $i = 0;
            $total_amount = 0; $total_received = 0; $tr_html = '';
            foreach($data as $val){
                $total_paid = 0;
                $pay_via = '';
                
                if($val->payment()->count() > 0 && !empty($val->payment->amount_1)) {
                    $pay_via .= $val->payment->payment_via_1.'('.$val->payment->payment_option_1.'): '.$val->payment->amount_1;
                    if($direct_bill != '') {
                        $direct_bill += $val->payment->amount_1 + $val->payment->direct_billing_amount_2;
                        $direct_billing_by = $val->payment->direct_billing_option_2;
                        if(!empty($direct_billing_by)) {
                            $direct_bill_title = $val->payment->payment_via_1.'('.$val->payment->payment_option_1.', '. $direct_billing_by .')';
                        }
                        else {
                            $direct_bill_title = $val->payment->payment_via_1.'('.$val->payment->payment_option_1.')';
                        }
                        
                    }
                }
                if($val->payment()->count() > 0 && !empty($val->payment->amount_2)) {
                    $pay_via .= ', '.$val->payment->payment_via_2.'('.$val->payment->payment_option_2.'): '.$val->payment->amount_2;
                    if($bank_pay != '') {
                        $bank_pay += $val->payment->amount_2;
                        $bank_pay_title = $val->payment->payment_via_2.'('.$val->payment->payment_option_2.')';
                    }
                }
                if($val->payment()->count() > 0 && !empty($val->payment->amount_3)) {
                    $pay_via .= ', '.$val->payment->payment_via_3.'('.$val->payment->payment_option_3.'): '.$val->payment->amount_3;
                    if($cash != '') {
                        $cash += $val->payment->amount_3;
                        $cash_title = $val->payment->payment_via_3.' ('.$val->payment->payment_option_3.')';
                    }
                }
                if($val->payment()->count() > 0 && !empty($val->payment->amount_4)) {
                    $pay_via .= ', '.$val->payment->payment_via_4.'('.$val->payment->payment_option_4.'): '.$val->payment->amount_4;
                    if($account != '') {
                        $account += $val->payment->amount_4;
                        $account_title = $val->payment->payment_via_3.' ('.$val->payment->payment_option_4.')';
                    }
                    
                }
                if($val->payment()->count() > 0 && !empty($val->payment->amount_5)) {
                    $pay_via .= ', '.$val->payment->payment_via_5.'('.$val->payment->payment_option_5.'): '.$val->payment->amount_5;
                    if($other_method != '') {
                        $other_method += $val->payment->amount_5;
                        $other_method_title = $val->payment->payment_via_5.'('.$val->payment->payment_option_5.')';
                    }
                }
                $pay_via = ltrim($pay_via, ', ');
                if($val->payment()->count() > 0) {
                    $total_paid = $val->payment->paid_amount;
                }
                
                // Get Services Name
                $service_ids = explode(",", $val->services);
                $result = Service::withTrashed()->whereIn('id', $service_ids)->pluck('service_name')->toArray();
                $ser_nm = implode(', ', $result);
                // End Get Services Name
                $total_amount += $val->final_amount;
                $total_received +=  $total_paid;

                $payvia_title = ($pay_via) ? $pay_via : 'Not Paid';

                $tr_html .= '<tr>
                                <td>'.get_formatted_date($val->invoice_date, 'M d, Y').'</td>
                                <td>'.$val->invoice_number.'</td>
                                <td>'.$ser_nm.'</td>
                                <td>'.$val->service_prices.'</td>
                                <td><a href="javascript:void(0);" data-bs-toggletip="tooltip" data-bs-title="'.$payvia_title.'"><i class="bi bi-currency-dollar"></i> '.number_format($val->final_amount, 2).'</a></td>
                                <td><a href="javascript:void(0);" data-bs-toggletip="tooltip" data-bs-title="Tax Amount"><i class="bi bi-currency-dollar"></i> '.number_format($val->hst_tax, 2).'</a></td>

                                <td><i class="bi bi-currency-dollar"></i> '.number_format($total_paid, 2).'</td>
                    </tr>';
            }

            $breakdown = '';
            if(!empty($direct_bill)) {
                $breakdown .= '<tr>
                            <td colspan="6"><div class="row text-end"><span class="fw-bold">Total '.$direct_bill_title.' </span></div></td>
                            <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($direct_bill, 2).'</span></td>
                        </tr>';
                
            }
            if(!empty($bank_pay)) {
                $breakdown .= '<tr>
                            <td colspan="6"><div class="row text-end"><span class="fw-bold">Total '.$bank_pay_title.': </span></div></td>
                            <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($bank_pay, 2).'</span></td>
                        </tr>';
            }
            if(!empty($cash)) {
                $breakdown .= '<tr>
                            <td colspan="6"><div class="row text-end"><span class="fw-bold">Total '.$cash_title.': </span></div></td>
                            <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($cash, 2).'</span></td>
                        </tr>';
            }
            if(!empty($account)) {
                $breakdown .= '<tr>
                            <td colspan="6"><div class="row text-end"><span class="fw-bold">Total '.$account_title.': </span></div></td>
                            <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($account, 2).'</span></td>
                        </tr>';
            }
            if(!empty($other_method)) {
                $breakdown .= '<tr>
                            <td colspan="6"><div class="row text-end"><span class="fw-bold">Total '.$other_method_title.': </span></div></td>
                            <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($other_method, 2).'</span></td>
                        </tr>';
            }

            $tr_html .= '<tr><td colspan="6">&nbsp;</td><td>&nbsp;</td></tr>
                        <tr>
                            <td colspan="6"><div class="row text-end"><span class="fw-bold">Total Amount: </span></div></td>
                            <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($total_amount, 2).'</span></td>
                        </tr>
                        '.$breakdown.'
                        <tr>
                            <td colspan="6"><div class="row text-end"><span class="fw-bold">Total Received: </span></div></td>
                            <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($total_received, 2).'</span></td>
                        </tr>';
            return response()->json(['status' => true, 'output' => $tr_html]);
        }
        else {
            return response()->json(['status' => true, 'output' => 'No Output']);
        }
    }

    /**
     * This function is responsible for download customer statement
     */
    public function customerStatementDownload(Request $request)
    {
        $user_id = $request->id;
        $name = $request->name;
        $mobile = $request->mobile;
        $start_dt = get_formatted_date($request->start_dt, 'Y-m-d');
        $end_dt = get_formatted_date($request->end_dt, 'Y-m-d');
        
        if(!empty($request->direct_billing)) {
            $direct_bill = 0;
        }
        else {
            $direct_bill = '';
        }

        if(!empty($request->bank_payment)) {
            $bank_pay = 0;
        }
        else {
            $bank_pay = '';
        }

        if(!empty($request->cash)) {
            $cash = 0;
        }
        else {
            $cash = '';
        }

        if(!empty($request->other_method)) {
            $other_method = 0;
        }
        else {
            $other_method = '';
        }

        $data = Invoice::with('payment')->whereDate('invoice_date', '>=', $start_dt)->whereDate('invoice_date', '<=', $end_dt)->where('customer_id', $user_id)->get();

        if ($data->isEmpty()) {
            return back()->with('error', 'No records found.');
        }

        // Pass data to a blade view
        $pdf = Pdf::loadView('admin.report.customer_statement_pdf', [
            'name' => $name,
            'mobile' => $mobile,
            'invoices' => $data,
            'start_dt' => $start_dt,
            'end_dt' => $end_dt,
            'direct_bill' => $direct_bill,
            'bank_pay' => $bank_pay,
            'cash' => $cash,
            'other_method' => $other_method
        ]);

        return $pdf->download('customer-statement.pdf');
    }

    /**
     * Show the Page where Profit and Loss can view.
     */
    public function revenue()
    {
        return view('admin.report.revenue');
    }

    /**
     * Show the Revenue Statement By Ajax Request
     */
    public function revenueStatement(Request $request)
    {
        $output = $this->revenueData($request->start_dt, $request->end_dt);
        if($output) {
            return response()->json(['status' => true, 'output' => $output]);
        }
        else {
            return response()->json(['status' => false]);
        }
        
    }

    public function revenuePdfDownload(Request $request)
    {
        $output = $this->revenueData($request->start_dt, $request->end_dt);
         $pdf = Pdf::loadView('admin.report.revenue_statement_pdf', [
            'output' => $output
        ]);
        $filename = 'revenue_summary_'.get_formatted_date($request->start_dt, 'Ymd').'-'.get_formatted_date($request->end_dt, 'Ymd');
        return $pdf->download('revenue_statement_pdf.pdf');
    }

    public function revenueExcelDownload(Request $request)
    {
        $output = $this->revenueData($request->start_dt, $request->end_dt);
        
        $filename = 'revenue_summary_'.get_formatted_date($request->start_dt, 'Ymd').'-'.get_formatted_date($request->end_dt, 'Ymd');
        return Excel::download(new RevenueSummaryExport($output), $filename.'.xlsx');
    }

    private function revenueData($start_dt, $end_dt) 
    {
        $start_dt = get_formatted_date($start_dt, 'Y-m-d');
        $end_dt   = get_formatted_date($end_dt, 'Y-m-d');

        $data = Invoice::with('payment')->whereDate('invoice_date', '>=', $start_dt)->whereDate('invoice_date', '<=', $end_dt)->get();

        if($data) {
            $total_billed = 0; $total_tax = 0; $total_received = 0;
            $total_credit = 0; $total_direct_bill = 0; $total_direct_2 = 0; $total_bank_pay = 0;
            $total_cash = 0; $total_account = 0; $total_other_pay = 0; $pending_amt = 0;
            // $total_discount = 0;
            foreach($data as $val) {
                
                $paid_amt = ($val->payment()->count() > 0) ? $val->payment->paid_amount : 0;
                $credit_amt = ($val->payment()->count() > 0)? $paid_amt - $val->hst_tax : 0;
                $amount_1 = ($val->payment()->count() > 0) ? $val->payment->amount_1 : 0;
                $direct_2 = ($val->payment()->count() > 0) ? $val->payment->direct_billing_amount_2 : 0;
                $amount_2 = ($val->payment()->count() > 0) ? $val->payment->amount_2 : 0;
                $amount_3 = ($val->payment()->count() > 0) ? $val->payment->amount_3 : 0;
                $amount_4 = ($val->payment()->count() > 0) ? $val->payment->amount_4 : 0;
                $amount_5 = ($val->payment()->count() > 0) ? $val->payment->amount_5 : 0;

                // get pending and partial amounts
                if($val->payment()->count() > 0 && ($val->payment_status == 'partial' || $val->payment_status == 'pending')) {
                    $pending_amt += $val->payment->total_amount - $val->payment->paid_amount;
                }

                $total_billed += $val->final_amount;
                $total_tax += $val->hst_tax;
                $total_received += $paid_amt;
                $total_credit += $credit_amt;
                
                $total_direct_bill += $amount_1;
                $total_direct_2 += $direct_2;
                $total_bank_pay += $amount_2;
                $total_cash += $amount_3;
                $total_account += $amount_4;
                $total_other_pay += $amount_5;
            }
            $total_recorded_amt = $total_direct_bill + $total_direct_2 + $total_bank_pay + $total_cash + $total_account + $total_other_pay;
            $received_amt = ($total_direct_bill + $total_direct_2 + $total_bank_pay + $total_cash + $total_other_pay) - $total_account;
            $output = [
                'start_dt' => $start_dt,
                'end_dt' => $end_dt,
                'total_billed' => number_format($total_billed, 2), 
                'total_tax' => number_format($total_tax, 2), 
                'total_received'=> number_format($total_received, 2), 
                'total_credit' => number_format($total_credit, 2),
                'total_direct_bill' => number_format($total_direct_bill + $total_direct_2, 2),
                'total_bank_pay' => number_format($total_bank_pay, 2),
                'total_cash' => number_format($total_cash, 2),
                'total_account' => number_format($total_account, 2),
                'total_other_pay' => number_format($total_other_pay, 2),
                'total_recorded_amount' => number_format($total_recorded_amt, 2),
                'received_amount'  => number_format($received_amt, 2),
                'pending_amount' => number_format($total_billed - $total_received, 2)
            ];
            return $output;
        }
        return false;
    }

    public function revenueChart()
    {
        $year = date('Y');
        $months = [];
        $revenues = [];
        $total_revenue = 0;
        for ($m = 1; $m <= 12; $m++) {

            $start_dt = date("$year-$m-01");
            $end_dt   = date("Y-m-t", strtotime($start_dt));

            $data = $this->revenueData($start_dt, $end_dt);
            echo $data['received_amount'];die;
            $months[] = date("M", strtotime($start_dt));

            $revenues[] = $data ? (float) str_replace(',', '', $data['received_amount']) : 0;
            $total_revenue += $data['received_amount'];
        }

        return view('admin.report.revenuechart', compact('months', 'revenues', 'total_revenue'));
    }

    /**
     * Show the page where Sales Tax can view
     */
    public function salesTax()
    {
        return view('admin.report.sales_tax');
    }

    /**
     * Show the Sales Tax according to date range by Ajax Request
     */
    public function salesTaxStatement(Request $request)
    {
        $start_dt = get_formatted_date($request->start_dt, 'Y-m-d');
        $end_dt   = get_formatted_date($request->end_dt, 'Y-m-d');
        $data = Invoice::where('invoice_date', '>=', $start_dt)->where('invoice_date', '<=', $end_dt)->where('payment_status', 'paid')->get();
        if(!empty($data)) {
            $net_tax = 0;
            foreach($data as $val) {
                $net_tax += $val->hst_tax;
            }
            return response()->json(['status' => true, 'net_tax' => number_format($net_tax, 2, '.')]);
        }
    }

    /**
     * Show the page from where Multiple Customer Statement can be serach
     */
    public function multipleCustomer()
    {
        return view('admin.report.multiple_customer_statement');
    }

    /**
     * Show the Multiple customer statement 
     */
    public function multipleCustomerStatement(Request $request)
    {
        $user_id = $request->id;
        $direct_bill = !empty($request->direct_billing) ? 0 : null;

        $bank_pay = !empty($request->bank_payment) ? 0 : null;

        $cash = !empty($request->cash) ? 0 : null;

        $other_method = !empty($request->other_method) ? 0 : null;
        
        $account = !empty($request->account) ? 0 : null;

        $user_id_arr = [$user_id];
        if(!empty($request->id_1)) {
            array_push($user_id_arr, $request->id_1);
        }
        if(!empty($request->id_2)) {
            array_push($user_id_arr, $request->id_2);
        }
        if(!empty($request->id_3)) {
            array_push($user_id_arr, $request->id_3);
        }
        $start_dt = get_formatted_date($request->start_dt, 'Y-m-d');
        $end_dt = get_formatted_date($request->end_dt, 'Y-m-d');

        $data = Invoice::with('payment')->whereDate('invoice_date', '>=', $start_dt)->whereDate('invoice_date', '<=', $end_dt)->whereIn('customer_id', $user_id_arr)->get();

        if(!empty($data)) {
            $tr_html = '';
            $total_amount = 0;
            $total_received = 0;
            $total_tax = 0;
            $total_credit = 0;
            $other_method_options = '';
            $account_options = '';
            foreach($data as $val) {
                $service_ids = explode(',', $val->services);
                $services = Service::withTrashed()->whereIn('id', $service_ids)->pluck('service_name')->toArray();
                // $service_txt = implode(", ", $services);
                
                $pos = strpos($val->service_prices, ',');
                $ser_price = '';
                if($pos === false) {
                    $ser_price = '$ '.$val->service_prices;
                }
                else {
                    $ser_prc = explode(',', $val->service_prices);
                    foreach($ser_prc as $pric){
                        $ser_price .= ' $'.$pric.', ';
                    }
                    $ser_price = rtrim($ser_price, ', ');
                }
                // $service_txt = rtrim($service_txt, ', ');
                if(!empty($val->payment)) {
                    $paid_amt = ($val->payment()->count() > 0)?$val->payment->amount_1 + $val->payment->direct_billing_amount_2 + $val->payment->amount_2 + $val->payment->amount_3 : 0;

                    $tr_html .= '<tr><td>'.get_formatted_date($val->invoice_date, 'M d, Y').'</td><td>'.$val->invoice_number.'</td><td>'.$val->customer_name.'</td><td>'.$val->hst_tax.'</td><td>'.number_format($val->final_amount, 2).'</td><td>'.number_format($paid_amt, 2) .'</td></tr>';

                    if($direct_bill !== null) {
                        $direct_bill += ($val->payment()->count() > 0)? $val->payment->amount_1 + $val->payment->direct_billing_amount_2:0;
                    }
                    if($bank_pay !== null) {
                        $bank_pay += ($val->payment()->count() > 0)? $val->payment->amount_2 : 0;
                        // $bank_pay_title = $val->payment->payment_via_2.'('.$val->payment->payment_option_2.')';
                    }
                    if($cash !== null) {
                        $cash += ($val->payment()->count() > 0) ? $val->payment->amount_3 : 0;
                        // $cash_title = $val->payment->payment_option_3;
                    }
                    if($other_method !== null) {
                        $other_method += ($val->payment()->count() > 0) ? $val->payment->amount_5 : 0;
                        if(!empty($val->payment->payment_option_5)) {
                            $other_method_options .= $val->payment->payment_option_5.', ';
                        }
                    }
                    if($account !== null) {
                        $account += ($val->payment()->count() > 0) ? $val->payment->amount_4 : 0;
                        if(!empty($val->payment->payment_option_4)) {
                            $account_options .= $val->payment->payment_option_4.', ';
                        }
                    }

                    $total_amount += $val->final_amount;
                    $total_received += ($val->payment()->count() > 0) ? $val->payment->amount_1+$val->payment->amount_2+$val->payment->amount_3:0;
                    $total_tax += $val->hst_tax;
                    $total_credit += ($val->payment()->count() > 0) ? ($val->payment->amount_1 + $val->payment->amount_2 + $val->payment->amount_3) - $val->hst_tax : 0;
                }
            }
            
            $breakdown = '';
            if(!empty($direct_bill)) {
                $breakdown .= '<tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Direct Billing: </span></div></td>
                            <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($direct_bill, 2).'</span></td>
                        </tr>';
                
            }
            if(!empty($bank_pay)) {
                $breakdown .= '<tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Bank Payment: </span></div></td>
                            <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($bank_pay, 2).'</span></td>
                        </tr>';
            }
            if(!empty($cash)) {
                $breakdown .= '<tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Cash: </span></div></td>
                            <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($cash, 2).'</span></td>
                        </tr>';
            }
            if(!empty($other_method)) {
                $breakdown .= '<tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Other Method: </span></div></td>
                            <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($other_method, 2).'</span></td>
                        </tr>';
            }
            if(!empty($account)) {
                $breakdown .= '<tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Account: </span></div></td>
                            <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($account, 2).'</span></td>
                        </tr>';
            }

            $tr_html .= '<tr><td colspan="5">&nbsp;</td><td>&nbsp;</td></tr>
                    <tr>
                        <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Amount: </span></div></td>
                        <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($total_amount, 2).'</span></td>
                    </tr>
                    '.$breakdown.'
                    <tr>
                        <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Received: </span></div></td>
                        <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($total_received, 2).'</span></td>
                    </tr>
                    <tr>
                        <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Tax: </span></div></td>
                        <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($total_tax, 2).'</span></td>
                    </tr>
                    <tr>
                        <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Credit: </span></div></td>
                        <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($total_credit, 2).'</span></td>
                    </tr>';

        }

        return response()->json(['status' => true, 'output' => $tr_html]);
    }

    /**
     * Send Email Customer Statement to Customer Email id
     */
    public function sendStatementToCustomer(Request $request)
    {
        try {
            $setting = getSetting();
            $default_mail = $request->default_mail;
            $other_single_email = $request->other_single_email;
            $user_id = $request->id;
            $name = $request->name;
            $mobile = $request->mobile;
            $start_dt = get_formatted_date($request->start_dt, 'Y-m-d');
            $end_dt = get_formatted_date($request->end_dt, 'Y-m-d');
            
            if(!empty($request->direct_billing)) {
                $direct_bill = 0;
            }
            else {
                $direct_bill = '';
            }

            if(!empty($request->bank_payment)) {
                $bank_pay = 0;
            }
            else {
                $bank_pay = '';
            }

            if(!empty($request->cash)) {
                $cash = 0;
            }
            else {
                $cash = '';
            }

            if(!empty($request->other_method)) {
                $other_method = 0;
            }
            else {
                $other_method = '';
            }

            $data = Invoice::with('payment')->whereDate('invoice_date', '>=', $start_dt)->whereDate('invoice_date', '<=', $end_dt)->where('customer_id', $user_id)->get();

            if ($data->isEmpty()) {
                return back()->with('error', 'No records found.');
            }

            // Pass data to a blade view
            $pdf = Pdf::loadView('admin.report.customer_statement_pdf', [
                'name' => $name,
                'mobile' => $mobile,
                'invoices' => $data,
                'start_dt' => $start_dt,
                'end_dt' => $end_dt,
                'direct_bill' => $direct_bill,
                'bank_pay' => $bank_pay,
                'cash' => $cash,
                'other_method' => $other_method
            ]);

            $to = '';
            $cc = '';
            if(!empty($default_mail) && empty($other_single_email)) {
                $to = $default_mail;
            }
            if(empty($default_mail) && !empty($other_single_email)) {
                $to = $other_single_email;
            }
            if(!empty($default_mail) && !empty($other_single_email)) {
                $to = $default_mail;
                $cc = $other_single_email;
            }

            // Send Email
            if($setting->global_mail == 1) {
                Mail::to($to)->cc($cc)
                ->send(new CustomerStatementMail($data, $start_dt, $end_dt, $pdf));
            }

            return response()->json(['status' => true, 'message' => 'Customer Statement sent successfully!']);
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Email Statement Could Not be Sent due to '.$e->getMessage()]);
        }
    }

    /**
     * Customer Report Print
     */
    
    public function printCustomerReport(Request $request)
    {
        $user_id = $request->id;
        $name = $request->name;
        $mobile = $request->mobile;
        $start_dt = get_formatted_date($request->start_dt, 'Y-m-d');
        $end_dt = get_formatted_date($request->end_dt, 'Y-m-d');
        
        if(!empty($request->direct_billing)) {
            $direct_bill = 0;
        }
        else {
            $direct_bill = '';
        }

        if(!empty($request->bank_payment)) {
            $bank_pay = 0;
        }
        else {
            $bank_pay = '';
        }

        if(!empty($request->cash)) {
            $cash = 0;
        }
        else {
            $cash = '';
        }

        if(!empty($request->other_method)) {
            $other_method = 0;
        }
        else {
            $other_method = '';
        }

        $data = Invoice::with('payment')->whereDate('invoice_date', '>=', $start_dt)->whereDate('invoice_date', '<=', $end_dt)->where('customer_id', $user_id)->get();

        if ($data->isEmpty()) {
            return back()->with('error', 'No records found.');
        }

        // Pass data to a blade view
        return view('admin.report.customer_statement_print', [
            'name' => $name,
            'mobile' => $mobile,
            'invoices' => $data,
            'start_dt' => $start_dt,
            'end_dt' => $end_dt,
            'direct_bill' => $direct_bill,
            'bank_pay' => $bank_pay,
            'cash' => $cash,
            'other_method' => $other_method
        ]);
    }

    /**
     * Send Email of Multiple Customer Statement to customer email id
     */
    public function multipleCustomerStatementDownload(Request $request)
    {
        $user_id = $request->id;
        $user_id_arr = [$user_id];

        if(!empty($request->id_1)) {
            array_push($user_id_arr, $request->id_1);
        }
        if(!empty($request->id_2)) {
            array_push($user_id_arr, $request->id_2);
        }
        if(!empty($request->id_3)) {
            array_push($user_id_arr, $request->id_3);
        }

        if(!empty($request->direct_billing)) {
            $direct_bill = 0;
        }
        else {
            $direct_bill = '';
        }

        if(!empty($request->bank_payment)) {
            $bank_pay = 0;
        }
        else {
            $bank_pay = '';
        }

        if(!empty($request->cash)) {
            $cash = 0;
        }
        else {
            $cash = '';
        }

        if(!empty($request->other_method)) {
            $other_method = 0;
        }
        else {
            $other_method = '';
        }

        $start_dt = get_formatted_date($request->start_dt, 'Y-m-d');
        $end_dt = get_formatted_date($request->end_dt, 'Y-m-d');

        $data = Invoice::with('payment')->whereDate('invoice_date', '>=', $start_dt)->whereDate('invoice_date', '<=', $end_dt)->whereIn('customer_id', $user_id_arr)->get();

        
        if(!empty($data)) {
            $tr_html = '<table><tr><td style="border:none;"><img src="'.public_path('admin_assets/assets/img/divine-touch-logo2.png').'" alt="Divine Touch Therapy" style="width: 120px;"></td></tr></table>
            <h3>Customer Statements</h3><table>
                            <thead>
                                <tr>
                                    <th>Invoice Date</th>
                                    <th>Name</th>
                                    <th>Billed ($)</th>
                                    <th>Tax ($)</th>
                                    <th>Received ($)</th>
                                    <th>Credit ($)</th>
                                    <th>Charge</th>
                                </tr>
                            </thead>
                            <tbody>';
            $total_billed = 0;
            $total_tax = 0;
            $total_credit = 0;
            $total_received = 0;
            foreach($data as $val){
                if($direct_bill != '') {
                    $direct_bill += $val->amount_1;
                }
                if($bank_pay != '') {
                    $bank_pay += $val->amount_2;
                }
                if($cash != '') {
                    $cash += $val->amount_3;
                }
                if($other_method != '') {
                    $other_method += $val->amount_5;
                }
                $tr_html .= '<tr><td>'.get_formatted_date($val->invoice_date, 'M d, Y').'</td><td>'.$val->customer_name.'</td><td>'.number_format($val->final_amount, 2).'</td><td>'.number_format($val->hst_tax, 2).'</td><td>'.number_format($val->payment->paid_amount, 2).'</td><td>'.number_format($val->payment->paid_amount - $val->hst_tax, 2).'</td><td>&nbsp;</td></tr>';
                $total_billed += $val->final_amount;
                $total_received += $val->payment->paid_amount;
                $total_tax += $val->hst_tax;
                $total_credit += $val->payment->paid_amount - $val->hst_tax;
            }

            $breakdown = '';
            if(!empty($direct_bill)) {
                $breakdown .= '<tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Direct Billing: </span></div></td>
                            <td colspan="2"><i class="bi bi-currency-dollar"></i><span class="">'.number_format($direct_bill, 2).'</span></td>
                        </tr>';
                
            }
            if(!empty($bank_pay)) {
                $breakdown .= '<tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Bank Payment: </span></div></td>
                            <td colspan="2"><i class="bi bi-currency-dollar"></i><span class="">'.number_format($bank_pay, 2).'</span></td>
                        </tr>';
            }
            if(!empty($cash)) {
                $breakdown .= '<tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Cash Payment: </span></div></td>
                            <td colspan="2"><i class="bi bi-currency-dollar"></i><span class="">'.number_format($cash, 2).'</span></td>
                        </tr>';
            }
            if(!empty($other_method)) {
                $breakdown .= '<tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Other Method Payment: </span></div></td>
                            <td colspan="2"><i class="bi bi-currency-dollar"></i><span class="">'.number_format($other_method, 2).'</span></td>
                        </tr>';
            }

            $tr_html .= '<tr><td colspan="6">&nbsp;</td><td>&nbsp;</td></tr>
                        '.$breakdown.'
                        <tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Billed: </span></div></td>
                            <td colspan="2"><i class="bi bi-currency-dollar"></i><span class="">'.number_format($total_billed, 2).'</span></td>
                        </tr>
                        <tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Tax: </span></div></td>
                            <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($total_tax, 2).'</span></td>
                        </tr>
                        <tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Received: </span></div></td>
                            <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($total_received, 2).'</span></td>
                        </tr>
                        <tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Credit: </span></div></td>
                            <td><i class="bi bi-currency-dollar"></i><span class="">'.number_format($total_credit, 2).'</span></td>
                        </tr></tbody></table>';
        }

        // create PDF
        $pdf = Pdf::loadView('admin.report.multiple_customer_statement_pdf', [
            'tr_html' => $tr_html
        ])->setPaper('a4', 'portrait');

        return $pdf->download('multiple_customer_statement.pdf');
    }

    /**
     * Send Email to customer of Multiple customer Statement
     */
    public function multipleCustomerStatementEmail(Request $request)
    {
        $setting = getSetting();
        $user_id = $request->id;
        $default_mail = $request->default_mail;
        $default_mail_1 = $request->default_mail_1;
        $default_mail_2 = $request->default_mail_2;
        $default_mail_3 = $request->default_mail_3;

        $other_single_email_m = $request->other_single_email_m;
        $user_id_arr = [$user_id];

        if(!empty($request->id_1)) {
            array_push($user_id_arr, $request->id_1);
        }
        if(!empty($request->id_2)) {
            array_push($user_id_arr, $request->id_2);
        }
        if(!empty($request->id_3)) {
            array_push($user_id_arr, $request->id_3);
        }

        $direct_bill = !empty($request->direct_billing) ? 0 : null;
        
        $bank_pay = !empty($request->bank_payment) ? 0 : null;
        
        $cash = !empty($request->cash) ? 0 : null;

        $other_method = !empty($request->other_method) ? 0 : null;

        $start_dt = get_formatted_date($request->start_dt, 'Y-m-d');
        $end_dt = get_formatted_date($request->end_dt, 'Y-m-d');

        $data = Invoice::with('payment')->whereDate('invoice_date', '>=', $start_dt)->whereDate('invoice_date', '<=', $end_dt)->whereIn('customer_id', $user_id_arr)->get();

        
        if(!empty($data)) {
            $tr_html = '<table><tr><td style="border:none;"><img src="'.public_path('admin_assets/assets/img/divine-touch-logo2.png').'" alt="Divine Touch Therapy" style="width: 120px;"></td></tr></table>
            <h3>Customer Statements</h3><table>
                            <thead>
                                <tr>
                                    <th>Invoice Date</th>
                                    <th>Name</th>
                                    <th>Billed ($)</th>
                                    <th>Tax ($)</th>
                                    <th>Received ($)</th>
                                    <th>Credit ($)</th>
                                    <th>Charge</th>
                                </tr>
                            </thead>
                            <tbody>';
            $total_billed = 0;
            $total_tax = 0;
            $total_credit = 0;
            $total_received = 0;
            foreach($data as $val){
                if($direct_bill != null) {
                    $direct_bill += ($val->payment()->count() > 0)?$val->payment->amount_1 + $val->payment->direct_billing_amount_2:0;
                }
                if($bank_pay != null) {
                    $bank_pay += ($val->payment()->count() > 0)?$val->payment->amount_2 : 0;
                }
                if($cash != null) {
                    $cash += ($val->payment()->count() > 0)?$val->payment->amount_3 : 0;
                }
                if($other_method != null) {
                    $other_method += ($val->payment()->count() > 0)?$val->payment->amount_5:0;
                }
                $paid_amt = ($val->payment()->count() > 0)?$val->payment->paid_amount:0;
                $credit_amt = ($val->payment()->count() > 0)?$val->payment->paid_amount - $val->hst_tax : 0;

                $tr_html .= '<tr><td>'.get_formatted_date($val->invoice_date, 'M d, Y').'</td><td>'.$val->customer_name.'</td><td>'.number_format($val->final_amount, 2).'</td><td>'.number_format($val->hst_tax, 2).'</td><td>'.number_format($paid_amt, 2).'</td><td>'.number_format($credit_amt, 2).'</td><td>&nbsp;</td></tr>';
                $total_billed += $val->final_amount;
                $total_received += $paid_amt;
                $total_tax += $val->hst_tax;
                $total_credit += $credit_amt;
            }

            $breakdown = '';
            if(!empty($direct_bill)) {
                $breakdown .= '<tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Direct Billing: </span></div></td>
                            <td colspan="2"><i class="bi bi-currency-dollar"></i><span class="">'.number_format($direct_bill, 2).'</span></td>
                        </tr>';
                
            }
            if(!empty($bank_pay)) {
                $breakdown .= '<tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Bank Payment: </span></div></td>
                            <td colspan="2"><i class="bi bi-currency-dollar"></i><span class="">'.number_format($bank_pay, 2).'</span></td>
                        </tr>';
            }
            if(!empty($cash)) {
                $breakdown .= '<tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Cash Payment: </span></div></td>
                            <td colspan="2"><i class="bi bi-currency-dollar"></i><span class="">'.number_format($cash, 2).'</span></td>
                        </tr>';
            }
            if(!empty($other_method)) {
                $breakdown .= '<tr>
                            <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Other Method Payment: </span></div></td>
                            <td colspan="2"><i class="bi bi-currency-dollar"></i><span class="">'.number_format($other_method, 2).'</span></td>
                        </tr>';
            }
            $tr_html .= '</tbody></table>';
        }

        // create PDF
        $pdf = Pdf::loadView('admin.report.multiple_customer_statement_pdf', [
            'tr_html' => $tr_html
        ])->setPaper('a4', 'portrait');

        $to = '';
        $cc = '';
        $all_emails = [
            $default_mail,
            $default_mail_1,
            $default_mail_2,
            $default_mail_3,
            $other_single_email_m
        ];
        
        $valid_emails = array_filter($all_emails);
        
        if(!empty($valid_emails) && count($valid_emails) > 1) {
            $to = array_shift($valid_emails);
            $cc = $valid_emails;
        }
        elseif(!empty($valid_emails) && count($valid_emails) == 1) {
            $to = $valid_emails;
            $cc = '';
        }
        // Send Email
        if($setting->global_mail == 1) {
            Mail::to($to)->cc($cc)
            ->send(new MultipleCustomerStatementMail($data, $start_dt, $end_dt, $pdf));
        }

        return response()->json(['status' => true, 'message' => 'Multiple Customer Statement sent successfully!']);
    }

    /**
     * 
     */
    public function printMultipleCustomerReport(Request $request)
    {
        $user_id = $request->id;
        $user_id_arr = [$user_id];

        if(!empty($request->id_1)) {
            array_push($user_id_arr, $request->id_1);
        }
        if(!empty($request->id_2)) {
            array_push($user_id_arr, $request->id_2);
        }
        if(!empty($request->id_3)) {
            array_push($user_id_arr, $request->id_3);
        }

        $start_dt = get_formatted_date($request->start_dt, 'Y-m-d');
        $end_dt = get_formatted_date($request->end_dt, 'Y-m-d');

        $data = Invoice::with('payment')->whereDate('invoice_date', '>=', $start_dt)->whereDate('invoice_date', '<=', $end_dt)->whereIn('customer_id', $user_id_arr)->get();

        if(!empty($data)) {
            $tr_html = '<table><tr><td style="border:none;"><img src="'.asset('admin_assets/assets/img/divine-touch-logo2.png').'" alt="Divine Touch Therapy" style="width: 120px;"></td></tr></table>
            <h3>Customer Statements</h3><table>
                            <thead>
                                <tr>
                                    <th>Invoice Date</th>
                                    <th>Name</th>
                                    <th>Billed ($)</th>
                                    <th>Tax ($)</th>
                                    <th>Received ($)</th>
                                    <th>Credit ($)</th>
                                    <th>Charge</th>
                                </tr>
                            </thead>
                            <tbody>';
            $total_billed = 0;
            $total_tax = 0;
            $total_credit = 0;
            $total_received = 0;
            foreach($data as $val){

                $paid_amt = ($val->payment()->count() > 0)?$val->payment->paid_amount:0;
                $credit_amt = ($val->payment()->count() > 0)?$val->payment->paid_amount - $val->hst_tax : 0;

                $tr_html .= '<tr><td>'.get_formatted_date($val->invoice_date, 'M d, Y').'</td><td>'.$val->customer_name.'</td><td>'.number_format($val->final_amount, 2).'</td><td>'.number_format($val->hst_tax, 2).'</td><td>'.number_format($paid_amt, 2).'</td><td>'.number_format($credit_amt, 2).'</td><td>&nbsp;</td></tr>';

                $total_billed += $val->final_amount;
                $total_received += ($val->payment()->count() > 0)?$val->payment->paid_amount:0;
                $total_tax += $val->hst_tax;
                $total_credit += ($val->payment()->count() > 0) ? $val->payment->paid_amount - $val->hst_tax : 0;
            }

            $tr_html .= '</tbody></table>';
        }

        // Pass data to a blade view
        return view('admin.report.multiple_customer_statement_print', [
            'tr_html' => $tr_html
        ]);
    }

    /**
     * Excel Customer Statement Download
     * 
     */
    public function customerStatementExcelDownload(Request $request)
    {
        $user_id = $request->id;
        $name = $request->name;
        $mobile = $request->mobile;
        $start_dt = get_formatted_date($request->start_dt, 'Y-m-d');
        $end_dt = get_formatted_date($request->end_dt, 'Y-m-d');
        
        if(!empty($request->direct_billing)) {
            $direct_bill = 0;
        }
        else {
            $direct_bill = '';
        }

        if(!empty($request->bank_payment)) {
            $bank_pay = 0;
        }
        else {
            $bank_pay = '';
        }

        if(!empty($request->cash)) {
            $cash = 0;
        }
        else {
            $cash = '';
        }

        if(!empty($request->other_method)) {
            $other_method = 0;
        }
        else {
            $other_method = '';
        }

        $data = Invoice::with('payment')->whereDate('invoice_date', '>=', $start_dt)->whereDate('invoice_date', '<=', $end_dt)->where('customer_id', $user_id)->get();

        if ($data->isEmpty()) {
            return back()->with('error', 'No records found.');
        }

        return Excel::download(new CustomerStatementExport($data, $name, $mobile), 'customer-excel-statement.xlsx');
    }

    public function multipleCustomerStatementExcelDownload(Request $request)
    {
        $user_id = $request->id;
        $type = $request->type;
        $start_dt = get_formatted_date($request->start_dt, 'Y-m-d');
        $end_dt = get_formatted_date($request->end_dt, 'Y-m-d');
        $user_id_arr = [$user_id];

        if(!empty($request->id_1)) {
            array_push($user_id_arr, $request->id_1);
        }
        if(!empty($request->id_2)) {
            array_push($user_id_arr, $request->id_2);
        }
        if(!empty($request->id_3)) {
            array_push($user_id_arr, $request->id_3);
        }

        // Selected Payment Methods
        if(!empty($request->direct_billing)) {
            $direct_bill = 0;
        }
        else {
            $direct_bill = '';
        }

        if(!empty($request->bank_payment)) {
            $bank_pay = 0;
        }
        else {
            $bank_pay = '';
        }

        if(!empty($request->cash)) {
            $cash = 0;
        }
        else {
            $cash = '';
        }

        if(!empty($request->other_method)) {
            $other_method = 0;
        }
        else {
            $other_method = '';
        }
        // End here Selected Payment Methods
        
        $data = Invoice::with('payment')->whereDate('invoice_date', '>=', $start_dt)->whereDate('invoice_date', '<=', $end_dt)->whereIn('customer_id', $user_id_arr)->get();

        if ($data->isEmpty()) {
            return back()->with('error', 'No records found.');
        }

        if($type == 'pdf') {
            if(!empty($data)) {
                $tr_html = '<table><tr><td style="border:none;"><img src="'.public_path('admin_assets/assets/img/divine-touch-logo2.png').'" alt="Divine Touch Therapy" style="width: 120px;"></td></tr></table>
                <h3>Customer Statements</h3><table>
                                <thead>
                                    <tr>
                                        <th>Invoice Date</th>
                                        <th>Name</th>
                                        <th>Billed ($)</th>
                                        <th>Tax ($)</th>
                                        <th>Received ($)</th>
                                        <th>Credit ($)</th>
                                        <th>Charge</th>
                                    </tr>
                                </thead>
                                <tbody>';
                $total_billed = 0;
                $total_tax = 0;
                $total_credit = 0;
                $total_amount = 0;
                $total_received = 0;
                foreach($data as $val){
                    if($direct_bill != '') {
                        $direct_bill += ($val->payment()->count() > 0) ? $val->payment->amount_1 + $val->payment->direct_billing_amount_2 : 0;
                    }
                    if($bank_pay != '') {
                        $bank_pay += ($val->payment()->count() > 0)?$val->payment->amount_2 : 0;
                    }
                    if($cash != '') {
                        $cash += ($val->payment()->count() > 0)?$val->payment->amount_3 : 0;
                    }
                    if($other_method != '') {
                        $other_method += ($val->payment()->count() > 0)?$val->payment->amount_5 : 0;
                    }

                    $paid_amt = ($val->payment()->count() > 0)?$val->payment->paid_amount : 0;
                    $credit_amt = ($val->payment()->count() > 0)?$val->payment->paid_amount - $val->hst_tax : 0;
                    
                    $tr_html .= '<tr><td>'.get_formatted_date($val->invoice_date, 'M d, Y').'</td><td>'.$val->customer_name.'</td><td>'.number_format($val->final_amount, 2).'</td><td>'.number_format($val->hst_tax, 2).'</td><td>'.number_format($paid_amt, 2).'</td><td>'.number_format($credit_amt, 2).'</td><td>&nbsp;</td></tr>';
                    $total_billed += $val->final_amount;
                    $total_received += $paid_amt;
                    $total_tax += $val->hst_tax;
                    $total_credit += $credit_amt;
                }

                $breakdown = '';
                if(!empty($direct_bill)) {
                    $breakdown .= '<tr>
                                <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Direct Billing: </span></div></td>
                                <td colspan="2"><i class="bi bi-currency-dollar"></i><span class="">'.number_format($direct_bill, 2).'</span></td>
                            </tr>';
                    
                }
                if(!empty($bank_pay)) {
                    $breakdown .= '<tr>
                                <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Bank Payment: </span></div></td>
                                <td colspan="2"><i class="bi bi-currency-dollar"></i><span class="">'.number_format($bank_pay, 2).'</span></td>
                            </tr>';
                }
                if(!empty($cash)) {
                    $breakdown .= '<tr>
                                <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Cash Payment: </span></div></td>
                                <td colspan="2"><i class="bi bi-currency-dollar"></i><span class="">'.number_format($cash, 2).'</span></td>
                            </tr>';
                }
                if(!empty($other_method)) {
                    $breakdown .= '<tr>
                                <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Other Method Payment: </span></div></td>
                                <td colspan="2"><i class="bi bi-currency-dollar"></i><span class="">'.number_format($other_method, 2).'</span></td>
                            </tr>';
                }

                // $tr_html .= '<tr><td colspan="6">&nbsp;</td><td>&nbsp;</td></tr>
                //             '.$breakdown.'
                //             <tr>
                //                 <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Billed: </span></div></td>
                //                 <td colspan="2">$<span class="">'.$total_billed.'</span></td>
                //             </tr>
                //             <tr>
                //                 <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Tax: </span></div></td>
                //                 <td colspan="2">$<span class="">'.$total_tax.'</span></td>
                //             </tr>
                //             <tr>
                //                 <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Received: </span></div></td>
                //                 <td colspan="2">$<span class="">'.$total_received.'</span></td>
                //             </tr>
                //             <tr>
                //                 <td colspan="5"><div class="row text-end"><span class="fw-bold">Total Credit: </span></div></td>
                //                 <td colspan="2">$<span class="">'.$total_credit.'</span></td>
                //             </tr></tbody></table>';
                $tr_html .= '</tbody></table>';
            }

            // create PDF
            $pdf = Pdf::loadView('admin.report.multiple_customer_statement_pdf', [
                'tr_html' => $tr_html
            ])->setPaper('a4', 'portrait');

            return $pdf->download('multiple_customer_statement.pdf');
        }
        if($type == 'xlsx') {
            return Excel::download(new MultipleCustomerStatementExport($data), 'multiple-customer-excel-statement.xlsx');
        }
    }
}