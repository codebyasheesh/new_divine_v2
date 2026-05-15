<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        h2, h4 {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td,
        .info-table td {
            padding: 6px;
            vertical-align: top;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #999;
            padding: 6px;
        }

        .items-table th {
            background-color: #f7ad29;
            text-align: left;
        }

        .totals-table td {
            padding: 6px;
        }

        .bordered {
            border: 1px solid #000;
        }

        .text-right {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .divider {
            border-top: 1px solid #666;
            margin: 10px 0;
        }
    </style>
</head>
<body>
@php
$settings = getSetting();
@endphp
<!-- ================= HEADER ================= -->
<table class="header-table">
    <tr>
        <td style="width: 25%;">
            <img src="{{ public_path('admin_assets/assets/img/oasis-massage-therapy-logo.png') }}" width="140">
        </td>

        <td style="width: 35%; vertical-align: bottom; text-align: left;">
            <div><strong>Therapist:</strong> {{ $data->therapist_name }}</div>
            <div><strong>License:</strong> {{ $data->therapist_license }}</div>
        </td>

        <td style="width: 40%;" class="text-right">
            <h2>Invoice</h2>
            <h4>{{ $settings->company_name }}</h4>
            <div>
                {{ $settings->company_address }},<br/>Telephone : {{ substr($settings->company_phone, 0, 3).'-'.substr($settings->company_phone, 3, 3).'-'.substr($settings->company_phone, 6, 4) }}<br />Email : {{ $settings->company_email }}
            </div>
        </td>
    </tr>
</table>

<div class="divider"></div>

<!-- ================= BILL TO + META ================= -->
<table class="info-table">
    <tr>
        <td style="width: 50%;">
            <div class="section-title">Bill To</div>

            @php
                $cty = '';
                $stat = '';
                $postal_cod = '';
                $addr = $data->address ?? $data->p_address;

                if(!empty($data->city)){
                    $cty = ($addr ? ', ' : '') . $data->city;
                } elseif(!empty($data->p_city)){
                    $cty = ($addr ? ', ' : '') . $data->p_city;
                }

                if(!empty($data->state)){
                    $stat = ($cty ? ', ' : '') . $data->state;
                } elseif(!empty($data->p_state)){
                    $stat = ($cty ? ', ' : '') . $data->p_state;
                }

                if(!empty($data->postal_code)){
                    $postal_cod = ($stat ? ', ' : '') . $data->postal_code;
                } elseif(!empty($data->p_postal_code)){
                    $postal_cod = ($stat ? ', ' : '') . $data->p_postal_code;
                }

                $comp_addr = $addr . $cty . $stat . $postal_cod;
            @endphp

            <div class="fw-bold">{{ $data->customer_name }}</div>
            <div>{{ $comp_addr }}</div>
            <div>{{ $data->customer_mobile }}</div>
            <div>{{ $data->customer_email }}</div>
        </td>

        <td style="width: 50%;" class="text-right">
            <div><strong>Invoice No:</strong> {{ $data->invoice_number }}</div>
            <div><strong>Date:</strong> {{ get_formatted_date($data->invoice_date, 'M d, Y') }}</div>

            @php
                $total_paid = $data->payment->paid_amount ?? 0;
                $amount_due = $data->final_amount - $total_paid;
            @endphp

            <div><strong>Payment Due:</strong> ${{ number_format($amount_due, 2) }}</div>
        </td>
    </tr>
</table>

<br>

<!-- ================= SERVICES ================= -->
<table class="items-table">
    <thead>
        <tr>
            <th style="width: 45%;">Service</th>
            <th style="width: 20%;">Duration</th>
            <th style="width: 10%;">Qty</th>
            <th style="width: 25%;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data->service_details as $key => $val)
        <tr>
            <td>{{ $val->service_name }}</td>
            <td>{{ $val->duration }}</td>
            <td>1</td>
            <td>${{ number_format($ser_prices[$key], 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

<!-- ================= TOTALS ================= -->
<table class="totals-table">
    <tr>
        <td style="width: 55%;"></td>
        <td style="width: 25%;" class="fw-bold">Sub Total</td>
        <td style="width: 20%;" class="text-right">
            ${{ number_format($data->subtotal, 2) }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td class="fw-bold" style="border-bottom: 1px solid #999;">
            Tax ({{ $settings->tax_name }} {{ $settings->tax_value }}%)
        </td>
        <td class="text-right" style="border-bottom: 1px solid #999;">
            ${{ number_format($data->hst_tax, 2) }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td class="fw-bold">Total</td>
        <td class="text-right fw-bold">
            ${{ number_format($data->final_amount, 2) }}
        </td>
    </tr>

        @if(!empty($data->payment->amount_1) && $data->payment->amount_1 != 0.00) 
        <tr>
            <td></td>
            <td>{{$data->payment->payment_option_1 ?? 'Direct Billing'}}:</td>
            <td class="text-right">
                <span>$</span><span id="total">{{ number_format($data->payment->amount_1, 2) }}</span>
            </td>
        </tr>
        @endif
        @if(!empty($data->payment->direct_billing_amount_2) && $data->payment->direct_billing_amount_2 != 0.00)
        <tr>
            <td></td>
            <td>{{$data->payment->direct_billing_option_2 ?? ''}}:</td>
            <td class="text-right">
                <span>$</span><span id="total">{{ number_format($data->payment->direct_billing_amount_2, 2) }}</span>
            </td>
        </tr>
        @endif
        @if(!empty($data->payment->amount_2) && $data->payment->amount_2 != 0.00) 
        <tr>
            <td></td>
            <td>{{(!empty($data->payment->payment_option_2)) ? $data->payment->payment_option_2 : 'Bank Payment'}}:</td>
            <td class="text-right">
                <span>$</span><span id="total">{{ number_format($data->payment->amount_2, 2) }}</span>
            </td>
        </tr>
        @endif
        
        @if(!empty($data->payment->amount_3) && $data->payment->amount_3 != 0.00)
        <tr>
            <td></td>
            <td>{{(!empty($data->payment->payment_option_3)) ? $data->payment->payment_option_3 : 'Cash'}}:</td>
            <td class="text-right">
                <span>$</span><span id="total">{{number_format($data->payment->amount_3, 2) }}</span>
            </td>
        </tr>
        @endif

        @if(!empty($data->payment->amount_4) && $data->payment->amount_4 != 0.00)
        <tr>
            <td></td>
            <td>Payment:</td>
            <td class="text-right">
                <span>$</span><span id="total">{{ number_format($data->payment->amount_4, 2) }}</span>
            </td>
        </tr>
        @endif

        @if(!empty($data->payment->amount_5) && $data->payment->amount_5 != 0.00)
        <tr>
            <td></td>
            <td>{{(!empty($data->payment->payment_option_5)) ? $data->payment->payment_option_5 : $data->payment->payment_via_5}}:</td>
            <td class="text-right">
                <span>$</span><span >{{ number_format($data->payment->amount_5, 2) }}</span>
            </td>
        </tr>
        @endif

    <tr>
        <td></td>
        <td class="fw-bold" style="border-top: 1px solid #999;">Amount Due</td>
        <td class="text-right fw-bold" style="border-top: 1px solid #999;">
            ${{ number_format($amount_due, 2) }}
        </td>
    </tr>
</table>

<br>

<!-- ================= NOTES ================= -->
<table>
    <tr>
        <td>
            <div class="section-title">Notes / Terms</div>
            <div>{{ $settings->notes }}</div>
            <div>{{ $settings->terms }}</div>
        </td>
    </tr>
</table>

<br>

<!-- ================= FOOTER ================= -->
<table>
    <tr>
        <td style="text-align:center; color:#666;">
            <strong>HST Reg #</strong> {{ $settings->hst_registration_no }}
        </td>
    </tr>
</table>

</body>
</html>