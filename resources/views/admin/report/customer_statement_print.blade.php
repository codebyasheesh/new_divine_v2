<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer Statement</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f5f5f5; }
        .text-end { text-align: right; }
    </style>
</head>
<body>
    <table style="border:none;">
        <tr>
            <td style="border:none;">
                <img src="{{public_path('admin_assets/assets/img/divine-touch-logo2.png')}}" alt="Divine Touch Therapy" style="max-width: 100%; width: 120px;">
            </td>
            <td style="width: 40%;border:none;">&nbsp;</td>
            <td style="width: 40%;border:none;">
                <h3>Customer Statement</h3>
                <p><strong>Name: </strong>{{$name}}<br><strong>Mobile: </strong>{{$mobile}}</p>
                <p><strong>Date Range:</strong> {{ get_formatted_date($start_dt, 'M d, Y') }} to {{ get_formatted_date($end_dt, 'M d, Y') }}</p>
            </td>
        </tr>
    </table>
    
    <table>
        <thead>
            <tr>
                <th>Invoice Date</th>
                <th>Name</th>
                <th>Billed ($)</th>
                <th>Tax ($)</th>
                <th>Received ($)</th>
                <th style="width:20%;">Credit ($)</th>
                <th>Charge</th>
            </tr>
        </thead>
        <tbody>
        @foreach($invoices as $invoice)
            <tr>
                <td>{{ get_formatted_date($invoice->invoice_date, 'M d, Y') }}</td>
                <td>{{ $invoice->customer_name }}</td>
                <td>{{ $invoice->final_amount }}</td>
                <td>{{$invoice->hst_tax }}</td>
                <td>{{($invoice->payment()->count() > 0)?$invoice->payment->paid_amount:'0' }}</td>
                <td>{{($invoice->payment()->count() > 0)?$invoice->payment->paid_amount - $invoice->hst_tax:'0'}}</td>
                <td>&nbsp;</td>
            </tr>
        @endforeach
        {{-- <tr>
            <td colspan="6" class="text-end"><strong>Total Amount:</strong></td>
            <td colspan="1">${{ $total_amount }}</td>
        </tr>
        
        @if($direct_bill)
        <tr>
            <td colspan="6" class="text-end"><strong>Direct Billing:</strong></td>
            <td colspan="1">${{ $direct_bill }}</td>
        </tr>
        @endif
        
        @if($bank_pay)
        <tr>
            <td colspan="6" class="text-end"><strong>Bank Payment:</strong></td>
            <td colspan="1">${{ $bank_pay }}</td>
        </tr>
        @endif
        @if($cash)
        <tr>
            <td colspan="6" class="text-end"><strong>Cash:</strong></td>
            <td colspan="1">${{ $cash }}</td>
        </tr>
        @endif
        @if($other_method)
        <tr>
            <td colspan="6" class="text-end"><strong>Other Method:</strong></td>
            <td colspan="1">${{ $other_method }}</td>
        </tr>
        @endif
        <tr>
            <td colspan="6" class="text-end"><strong>Total Received:</strong></td>
            <td colspan="1">${{ $total_received }}</td>
        </tr>
        <tr>
            <td colspan="6" class="text-end"><strong>Total Outstanding:</strong></td>
            <td colspan="1">${{ $total_amount - $total_received }}</td>
        </tr> --}}
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
