<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class SquareWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        $eventType = $payload['type'] ?? null;

        if ($eventType == 'payment.updated') {

            $payment = $payload['data']['object']['payment'];

            if ($payment['status'] == 'COMPLETED') {

                $orderId = $payment['order_id'];

                $record = Payment::where('square_order_id', $orderId)->first();

                if ($record) {
                    if(empty($record->transaction_id)) {
                        $record->square_status = 'paid';
                        $record->payment_via_2 = 'Bank Payment';
                        $record->payment_option_2 = 'Online';
                        $record->amount_2 = $payment['amount_money']['amount'] / 100;
                        $record->payment_method = 'square';
                        $record->paid_amount = $record->paid_amount + ($payment['amount_money']['amount'] / 100);
                        if($record->paid_amount < $record->total_amount) {
                            Invoice::where('id', $record->invoice_id)->update(['payment_status' => 'partial']);
                        }
                        if($record->paid_amount == $record->total_amount){
                            Invoice::where('id', $record->invoice_id)->update(['payment_status' => 'paid']);
                        }
                        $record->transaction_id = $payment['id'];

                        $record->save();
                    }
                }
            }
        }

        return response()->json(['success'=>true]);
    }
}
