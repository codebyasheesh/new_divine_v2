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
                {{-- <h3>Revenue Statement</h3> --}}
                <p><strong>Date Range:</strong> {{ get_formatted_date($output['start_dt'], 'M d, Y') }} to {{ get_formatted_date($output['end_dt'], 'M d, Y') }}</p>
            </td>
        </tr>
    </table>
    
    <table>
        <tbody>
            <tr>
                <td><strong>Invoiced Total:</strong></td>
                <td></td>
            </tr>
            <tr>
                <td>Total Billed (Invoiced Amount Including Tax):</td>
                <td><strong>${{$output['total_billed']}}</strong></td>
            </tr>
            <tr>
                <td>Tax (Invoiced Tax Amount):</td>
                <td>${{$output['total_tax']}}</td>
            </tr>
            <tr>
                <td><strong>Recorded / Pending A:</strong></td>
                <td></td>
            </tr>
            <tr>
                <td>Direct Billing:</td>
                <td>${{ $output['total_direct_bill'] }}</td>
            </tr>
            <tr>
                <td>Bank Payment:</td>
                <td>${{ $output['total_bank_pay'] }}</td>
            </tr>
            <tr>
                <td>Cash Payment:</td>
                <td>${{ $output['total_cash'] }}</td>
            </tr>
            <tr>
                <td>Account Payment:</td>
                <td>${{ $output['total_account'] }}</td>
            </tr>
            <tr>
                <td>Other Payment:</td>
                <td>${{ $output['total_other_pay'] }}</td>
            </tr>
            <tr>
                <td><strong>Total Recorded Amount:</strong></td>
                <td>${{ $output['total_recorded_amount'] }}</td>
            </tr>
            <tr>
                <td><strong>Received Amount (Recorded Amount w/o Account Payment)*:</strong></td>
                <td>${{ $output['received_amount'] }}</td>
            </tr>
            <tr>
                <td><strong>Pending Amount (Includes partial pending amount):</strong></td>
                <td>${{ $output['pending_amount'] }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
