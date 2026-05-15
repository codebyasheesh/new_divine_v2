<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Show the Record Payment Screen
     */
    public function recordPayment($invoice_id) 
    {
        $invoice = Invoice::where('id', $invoice_id)->first();
        $payment = Payment::where('invoice_id', $invoice_id)->first();
        if(!empty($payment)) {
            return view('admin.payment.record-payment', compact('invoice', 'payment'));
        }
        else {
            $payment = '';
            return view('admin.payment.record-payment', compact('invoice', 'payment'));
        }
        
    }

    public function saveRecordPayment(Request $request)
    {
        try {
            DB::beginTransaction();
            $paid_value = 0;
            if($request->id > 0) {
                $payment = Payment::find($request->id);
                
                if(isset($request->paid_via_1)) {
                    $payment->payment_via_1 = $request->paid_via_1 ?? '';
                    $payment->payment_option_1 = $request->payment_option_1 ?? '';
                    if($request->payment_value_1 != '') {
                        $payment->amount_1 = $request->payment_value_1;
                        $payment->paid_amount += $request->payment_value_1;
                    }
                }

                if(isset($request->direct_billing_2)) {
                    $payment->direct_billing_option_2 = $request->direct_option_1 ?? '';
                    if($request->e_payment_value_1 != '') {
                        $payment->direct_billing_amount_2 = $request->e_payment_value_1;
                        $payment->paid_amount += $request->e_payment_value_1;
                    }
                }

                if(isset($request->paid_via_2)) {
                    $payment->payment_via_2 = $request->paid_via_2 ?? '';
                    $payment->payment_option_2 = $request->payment_option_2 ?? '';
                    if($request->e_payment_value_2 != '') {
                        $payment->amount_2 = $payment->amount_2 + $request->e_payment_value_2;
                        $payment->paid_amount += $request->e_payment_value_2 ?? 0;
                    }
                }
                if(isset($request->paid_via_3)) {
                    $payment->payment_via_3 = $request->paid_via_3 ?? '';
                    $payment->payment_option_3 = $request->payment_option_3 ?? '';
                    if($request->e_payment_value_3 != '') {
                        $payment->amount_3 = $payment->amount_3 + $request->e_payment_value_3;
                        $payment->paid_amount += $request->e_payment_value_3;
                    }
                }
                
                if(isset($request->paid_via_4)) {
                    $payment->payment_via_4 = $request->paid_via_4 ?? '';
                    $payment->payment_option_4 = $request->payment_option_4 ?? '';
                    if($request->e_payment_value_4 != '') {
                        $payment->amount_4 += $request->e_payment_value_4;
                        $payment->paid_amount += $request->e_payment_value_4;
                    }
                }
                if(isset($request->paid_via_5)) {
                    $payment->payment_via_5 = $request->paid_via_5 ?? '';
                    $payment->payment_option_5 = $request->payment_option_5 ?? '';
                    if($request->e_payment_value_5 != '') {
                        $payment->amount_5 += $request->e_payment_value_5;
                        $payment->paid_amount += $request->e_payment_value_5 ?? 0;
                    }
                }
                // pr($request->toArray()); 
                
                $p_amt = (int) round($payment->paid_amount * 100);
                $tot_amt = (int) round($payment->total_amount * 100);
                if($p_amt > $tot_amt) {
                    return redirect()->back()->with('error', 'Total Paid Amount exceed from Total Required Payment, Please correct it');
                }
                /*if($payment->paid_amount > $payment->total_amount) {
                    return redirect()->back()->with('error', 'Total Paid Amount exceed from Total Required Payment, Please correct it');
                }*/
                // die('sds');
                $payment->save();
                $data = Payment::where('id', $payment->id)->first();
                if($data->total_amount == $data->paid_amount) {
                    Invoice::where('id', $payment->invoice_id)->update(['payment_status' => 'paid']);
                    $booking_dtl = Invoice::where('id', $payment->invoice_id)->first();
                    if(!empty($booking_dtl->booking_id)) {
                        Booking::where('id', $booking_dtl->booking_id)->update(['booking_status' => 'completed']);
                    }
                }
                elseif($data->total_amount > $data->paid_amount) {
                    Invoice::where('id', $payment->invoice_id)->update(['payment_status' => 'partial']);
                }
            }
            else {
                $payment = new Payment();
                
                $payment->invoice_id = $request->invoice_id;
                $payment->total_amount = $request->final_amount;
                $payment->payment_via_1 = $request->paid_via_1 ?? '';
                $payment->payment_option_1 = $request->payment_option_1 ?? '';
                $payment->amount_1 = $request->payment_value_1 ?? 0;

                $paid_value += $request->payment_value_1 ?? 0;

                $payment->payment_via_2 = $request->paid_via_2 ?? '';
                $payment->payment_option_2 = $request->payment_option_2 ?? '';
                $payment->amount_2 = $request->payment_value_2 ?? 0;

                $paid_value += $request->payment_value_2 ?? 0;

                $payment->payment_via_3 = $request->paid_via_3 ?? '';
                $payment->payment_option_3 = $request->payment_option_3 ?? '';
                $payment->amount_3 = $request->payment_value_3 ?? 0;

                $paid_value += $request->payment_value_3 ?? 0;

                $payment->payment_via_4 = $request->paid_via_4 ?? '';
                $payment->payment_option_4 = $request->payment_option_4 ?? '';
                $payment->amount_4 = $request->payment_value_4 ?? 0;

                $paid_value += $request->payment_value_4 ?? 0;

                $payment->payment_via_5 = $request->paid_via_5 ?? '';
                $payment->payment_option_5 = $request->payment_option_5 ?? '';
                $payment->amount_5 = $request->payment_value_5 ?? 0;

                $paid_value += $request->payment_value_5 ?? 0;

                $payment->paid_amount = $paid_value;
                $payment->payment_date = date('Y-m-d');
                $payment->invoice_date = get_formatted_date($request->invoice_date, 'Y-m-d H:i:s');
                // die('else');
                $payment->save();

                $data = Payment::where('id', $payment->id)->first();
                if($data->total_amount == $data->paid_amount) {
                    Invoice::where('id', $request->invoice_id)->update(['payment_status' => 'paid']);
                    $booking_dtl = Invoice::where('id', $request->invoice_id)->first();
                    if(!empty($booking_dtl->booking_id)) {
                        Booking::where('id', $booking_dtl->booking_id)->update(['booking_status' => 'completed']);
                    }
                }
                elseif($data->total_amount > $data->paid_amount) {
                    Invoice::where('id', $request->invoice_id)->update(['payment_status' => 'partial']);
                }
            }
            DB::commit();
            return redirect()->route('admin.invoices')->with('success', 'Payment Received Successfully');
        }
        catch(Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to record payment '.$e->getMessage());
        }
    }
}
