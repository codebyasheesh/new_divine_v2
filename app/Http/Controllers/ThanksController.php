<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Square\SquareClient;
use Square\Environments;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class ThanksController extends Controller
{
    public function index(Request $request)
    {
        $paymentId = $request->query('paymentId');

        if ($paymentId) {
            $this->processPayment($paymentId);
        }

        return view('frontend.thanks.index');
    }

    private function processPayment($paymentId)
    {
        $environment = config('square.environment') === 'production' ? Environments::Production : Environments::Sandbox;

        $client = new SquareClient(
            token: config('square.access_token'),
            options: [
                'baseUrl' => $environment->value
            ]
        );

        try {
            $paymentResponse = $client->payments->get($paymentId);

            if ($paymentResponse->getErrors()) {
                // Log error
                return;
            }

            $payment = $paymentResponse->getPayment();
            $status = $payment->getStatus();

            if ($status === 'COMPLETED') {
                $orderId = $payment->getOrderId();

                $orderResponse = $client->orders->retrieve($orderId, config('square.location_id'));

                if ($orderResponse->getErrors()) {
                    // Log
                    return;
                }

                $order = $orderResponse->getOrder();
                $lineItems = $order->getLineItems();

                if ($lineItems && count($lineItems) > 0) {
                    $name = $lineItems[0]->getName();
                    $invoiceNumber = str_replace('Invoice Payment - ', '', $name);

                    $invoice = Invoice::where('invoice_number', $invoiceNumber)->first();

                    if ($invoice) {
                        // Check if payment already recorded
                        $existingPayment = Payment::where('invoice_id', $invoice->id)->first();

                        if (!$existingPayment) {
                            $amount = $payment->getAmountMoney()->getAmount() / 100;

                            $paymentRecord = new Payment();
                            $paymentRecord->invoice_id = $invoice->id;
                            $paymentRecord->total_amount = $invoice->final_amount;
                            $paymentRecord->payment_via_5 = 'Square';
                            $paymentRecord->payment_option_5 = 'Online';
                            $paymentRecord->amount_5 = $amount;
                            $paymentRecord->paid_amount = $invoice->amount_1 + $invoice->amount_2 + $invoice->amount_3 + $invoice->amount_4 + $amount;
                            $paymentRecord->payment_date = now()->toDateString();
                            $paymentRecord->invoice_date = $invoice->invoice_date;
                            $paymentRecord->save();

                            // Update status
                            if ($amount >= $invoice->final_amount) {
                                $invoice->payment_status = 'paid';
                            } else {
                                $invoice->payment_status = 'partial';
                            }
                            $invoice->save();
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Log exception
        }
    }
}
