@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Record Payment</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.invoices') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Record Payment</li>
        </ol>
        </div>
    </div>
    {{--end::Row--}}
    </div>
    {{--end::Container--}}
</div>

<div class="app-content">
    {{--begin::Container--}}
    <div class="container-fluid">
    {{--begin::Row--}}
        <div class="row g-4">
            <div class="col-md-12">
  
                  @if ($errors->any())
                    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; margin-bottom: 15px;">
                        <h3>Validation Errors:</h3>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                  @endif
                  {{--begin::Alert--}}
                  {{--begin::Form--}}
                  <form action="{{ route('admin.save_payment') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{(!empty($payment->id))?$payment->id:''}}">
                    <input type="hidden" id="paid_amount" value="{{!empty($payment->paid_amount)?$payment->paid_amount:''}}">
                    <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                    <div class="card card-info card-outline mb-4">
                    {{--begin::Header--}}
                        <div class="card-header"><div class="card-title fw-bold">Record a Payment for Invoice: <span class="text-success">{{$invoice->invoice_number}}</span><br><strong> Name:&nbsp;</strong> <span style="font-weight: normal;"> {{$invoice->customer_name}}</span>, <strong> Mobile: </strong><span style="font-weight: normal;">{{$invoice->customer_mobile}}</span> <strong>, Email: </strong><span style="font-weight: normal;">{{$invoice->customer_email}}</span></div></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="row">
                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Payment Date</label>
                                            <input type="text" name="payment_date" id="payment_date" class="form-control" value="{{(isset($payment->payment_date))?get_formatted_date($payment->payment_date, 'M d Y'): date('M d Y')}}">
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="final_amount" class="form-label fw-bold">Invoice Date: <span class="text-danger">*</span></label>
                                            <input type="text" name="invoice_date" id="invoice_date" class="form-control" value="{{(isset($payment->invoice_date))?get_formatted_date($payment->invoice_date, 'M d, Y h:i A'):get_formatted_date($invoice->created_at, 'M d, Y h:i A')}}" readonly>
                                            
                                            @error('invoice_date')
                                            <div id="invoice_dateHelp" class="form-text text-danger" id="error_invoice_date">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="final_amount" class="form-label fw-bold">Total Amount: <span class="text-danger">*</span></label>
                                            <input
                                            type="text"
                                            class="form-control" name="final_amount"
                                            id="final_amount" value="{{ (isset($payment->total_amount))?$payment->total_amount:$invoice->final_amount }}" aria-describedby="amountHelp" readonly />
                                            
                                            @error('final_amount')
                                            <div id="final_amountHelp" class="form-text text-danger" id="error_final_amount">{{ $message }}</div>
                                            @enderror
                                            
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-4">
                                        <div class="form-group">
                                            <label for="paid_via" class="form-label fw-bold">Payment Via 1: <span class="text-danger">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="paid_via_1"
                                            id="paid_via_1" value="Direct Billing" onclick="enableDisableLevel2(1);" {{(!empty($payment->amount_1) && $payment->amount_1 != 0.00)?"disabled":''}} {{(!empty($payment->payment_via_1))?'checked':''}}>
                                                <label class="form-check-label" for="paid_via_1">
                                                    Direct Billing
                                                </label>
                                            </div>
                                            @error('paid_via_1')
                                            <div id="paid_via_1Help" class="form-text text-danger" id="error_paid_via_1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="payment_option_1" class="form-label fw-bold">Payment Option 1: <span class="text-danger">*</span></label>
                                            <select class="form-select" name="payment_option_1"
                                            id="payment_option_1" onchange="hideShowLevel3(1);" {{(isset($payment->payment_option_1) && $payment->payment_option_1 != '')?'disabled':'disabled'}}>
                                                <option value="">Select</option>
                                                <option value="AGA Financial" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'AGA Financial')?'selected':''}}>AGA Financial</option>
                                                <option value="Beneva" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Beneva')?'selected':''}}>Beneva</option>
                                                <option value="Blue Cross" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Blue Cross')?'selected':''}}>Blue Cross</option>
                                                <option value="BPA" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'BPA')?'selected':''}}>BPA</option>
                                                <option value="Canada Life" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Canada Life')?'selected':''}}>Canada Life</option>
                                                <option value="Canada Life PSHCP" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Canada Life PSHCP')?'selected':''}}>Canada Life PSHCP</option>
                                                <option value="Canadian Construction Workers Union" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Canadian Construction Workers Union')?'selected':''}}>Canadian Construction Workers Union</option>
                                                <option value="Chambers of Commerce" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Chambers of Commerce')?'selected':''}}>Chambers of Commerce</option>
                                                <option value="CINUP" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'CINUP')?'selected':''}}>CINUP</option>
                                                <option value="ClaimSecure" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'ClaimSecure')?'selected':''}}>ClaimSecure</option>
                                                <option value="Co-operators" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Co-operators')?'selected':''}}>Co-operators</option>
                                                <option value="Cowan" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Cowan')?'selected':''}}>Cowan</option>
                                                <option value="Desjardins" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Desjardins')?'selected':''}}>Desjardins</option>
                                                <option value="Empire Life" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Empire Life')?'selected':''}}>Empire Life</option>
                                                <option value="Equitable" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Equitable')?'selected':''}}>Equitable</option>
                                                <option value="First Canadian" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'First Canadian')?'selected':''}}>First Canadian</option>
                                                <option value="GMS Carriers 49 and 50" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'GMS Carriers 49 and 50')?'selected':''}}>GMS Carriers 49 and 50</option>
                                                <option value="GreenShield" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'GreenShield')?'selected':''}}>GreenShield</option>
                                                <option value="GroupHEALTH" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'GroupHEALTH')?'selected':''}}>GroupHEALTH</option>
                                                <option value="GroupSource" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'GroupSource')?'selected':''}}>GroupSource</option>
                                                <option value="HCAI - MVA" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'HCAI - MVA')?'selected':''}}>HCAI - MVA</option>
                                                <option value="Industrial Alliance" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Industrial Alliance')?'selected':''}}>Industrial Alliance</option>
                                                <option value="Johnson Inc." {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Johnson Inc.')?'selected':''}}>Johnson Inc.</option>
                                                <option value="Johnston Group" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Johnston Group')?'selected':''}}>Johnston Group</option>
                                                <option value="LiUna Local 183" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'LiUna Local 183')?'selected':''}}>LiUna Local 183</option>
                                                <option value="LiUna Local 506" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'LiUna Local 506')?'selected':''}}>LiUna Local 506</option>
                                                <option value="Manion" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Manion')?'selected':''}}>Manion</option>
                                                <option value="Manulife" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Manulife')?'selected':''}}>Manulife</option>
                                                <option value="Maximum Benefit" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Maximum Benefit')?'selected':''}}>Maximum Benefit</option>
                                                <option value="MDM Insurance Services" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'MDM Insurance Services')?'selected':''}}>MDM Insurance Services</option>
                                                <option value="NexGenRx" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'NexGenRx')?'selected':''}}>NexGenRx</option>
                                                <option value="OTIP - Manulife" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'OTIP - Manulife')?'selected':''}}>OTIP - Manulife</option>
                                                <option value="People Corporation" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'People Corporation')?'selected':''}}>People Corporation</option>
                                                <option value="RWAM" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'RWAM')?'selected':''}}>RWAM</option>
                                                <option value="Simply Benefits" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Simply Benefits')?'selected':''}}>Simply Benefits</option>
                                                <option value="SSQ" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'SSQ')?'selected':''}}>SSQ</option>
                                                <option value="Sun Life Financial" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Sun Life Financial')?'selected':''}}>Sun Life Financial</option>
                                                <option value="TELUS AdjudiCare" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'TELUS AdjudiCare')?'selected':''}}>TELUS AdjudiCare</option>
                                                <option value="Union Benefits" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Union Benefits')?'selected':''}}>Union Benefits</option>
                                                <option value="UV Insurance" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'UV Insurance')?'selected':''}}>UV Insurance</option>
                                                
                                            </select>
                                            @error('payment_option_1')
                                            <div id="payment_option_1Help" class="form-text text-danger" id="error_payment_option_1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-3 {{ (!empty($payment->id) && $payment->amount_1 != 0.00)?'':'d-none' }}" id="pay_div_val_1">
                                            <label class="form-label fw-bold">Amount: <span class="text-danger">*</span></label>
                                            <input type="text" name="payment_value_1" id="payment_value_1" value="{{ (!empty($payment->amount_1))?$payment->amount_1:'' }}" class="form-control" {{(!empty($payment->amount_1))?'disabled':''}} onkeyup="calculateRemain(1);">
                                        </div>
                                        @if(!empty($payment->id) && $payment->amount_1 != 0.00) 
                                            <div class="form-group mt-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="direct_billing_2"
                                                id="direct_billing_2" value="yes" {{(!empty($payment->direct_billing_amount_2) && $payment->direct_billing_amount_2 != 0.00)?"disabled":''}} {{(!empty($payment->direct_billing_option_2))?'checked':''}}>
                                                    <label class="form-check-label" for="direct_billing_2">
                                                        Direct Billing 2
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label for="direct_option_1" class="form-label fw-bold">Direct Option 1: <span class="text-danger">*</span></label>
                                                <select class="form-select" name="direct_option_1"
                                                id="direct_option_1" onchange="" {{(isset($payment->direct_billing_option_2) && $payment->direct_billing_option_2 != '')?'disabled':'disabled'}}>
                                                    <option value="">Select</option>
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'AGA Financial')
                                                    <option value="AGA Financial" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'AGA Financial')?'selected':''}}>AGA Financial</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Beneva')
                                                    <option value="Beneva" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Beneva')?'selected':''}}>Beneva</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Blue Cross')
                                                    <option value="Blue Cross" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Blue Cross')?'selected':''}}>Blue Cross</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'BPA')
                                                    <option value="BPA" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'BPA')?'selected':''}}>BPA</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Canada Life')
                                                    <option value="Canada Life" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Canada Life')?'selected':''}}>Canada Life</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Canada Life PSHCP')
                                                    <option value="Canada Life PSHCP" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Canada Life PSHCP')?'selected':''}}>Canada Life PSHCP</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Canadian Construction Workers Union')
                                                    <option value="Canadian Construction Workers Union" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Canadian Construction Workers Union')?'selected':''}}>Canadian Construction Workers Union</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Chambers of Commerce')
                                                    <option value="Chambers of Commerce" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Chambers of Commerce')?'selected':''}}>Chambers of Commerce</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'CINUP')
                                                    <option value="CINUP" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'CINUP')?'selected':''}}>CINUP</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'ClaimSecure')
                                                    <option value="ClaimSecure" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'ClaimSecure')?'selected':''}}>ClaimSecure</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Co-operators')
                                                    <option value="Co-operators" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Co-operators')?'selected':''}}>Co-operators</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Cowan')
                                                    <option value="Cowan" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Cowan')?'selected':''}}>Cowan</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Desjardins')
                                                    <option value="Desjardins" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Desjardins')?'selected':''}}>Desjardins</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Empire Life')
                                                    <option value="Empire Life" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Empire Life')?'selected':''}}>Empire Life</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Equitable')
                                                    <option value="Equitable" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Equitable')?'selected':''}}>Equitable</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'First Canadian')
                                                    <option value="First Canadian" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'First Canadian')?'selected':''}}>First Canadian</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'GMS Carriers 49 and 50')
                                                    <option value="GMS Carriers 49 and 50" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'GMS Carriers 49 and 50')?'selected':''}}>GMS Carriers 49 and 50</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'GreenShield')
                                                    <option value="GreenShield" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'GreenShield')?'selected':''}}>GreenShield</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'GroupHEALTH')
                                                    <option value="GroupHEALTH" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'GroupHEALTH')?'selected':''}}>GroupHEALTH</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'GroupSource')
                                                    <option value="GroupSource" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'GroupSource')?'selected':''}}>GroupSource</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'HCAI - MVA')
                                                    <option value="HCAI - MVA" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'HCAI - MVA')?'selected':''}}>HCAI - MVA</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Industrial Alliance')
                                                    <option value="Industrial Alliance" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Industrial Alliance')?'selected':''}}>Industrial Alliance</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Johnson Inc.')
                                                    <option value="Johnson Inc." {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Johnson Inc.')?'selected':''}}>Johnson Inc.</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Johnston Group')
                                                    <option value="Johnston Group" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Johnston Group')?'selected':''}}>Johnston Group</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'LiUna Local 183')
                                                    <option value="LiUna Local 183" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'LiUna Local 183')?'selected':''}}>LiUna Local 183</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'LiUna Local 506')
                                                    <option value="LiUna Local 506" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'LiUna Local 506')?'selected':''}}>LiUna Local 506</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Manion')
                                                    <option value="Manion" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Manion')?'selected':''}}>Manion</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Manulife')
                                                    <option value="Manulife" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Manulife')?'selected':''}}>Manulife</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Maximum Benefit')
                                                    <option value="Maximum Benefit" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Maximum Benefit')?'selected':''}}>Maximum Benefit</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'MDM Insurance Services')
                                                    <option value="MDM Insurance Services" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'MDM Insurance Services')?'selected':''}}>MDM Insurance Services</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'NexGenRx')
                                                    <option value="NexGenRx" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'NexGenRx')?'selected':''}}>NexGenRx</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'OTIP - Manulife')
                                                    <option value="OTIP - Manulife" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'OTIP - Manulife')?'selected':''}}>OTIP - Manulife</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'People Corporation')
                                                    <option value="People Corporation" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'People Corporation')?'selected':''}}>People Corporation</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'RWAM')
                                                    <option value="RWAM" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'RWAM')?'selected':''}}>RWAM</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Simply Benefits')
                                                    <option value="Simply Benefits" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Simply Benefits')?'selected':''}}>Simply Benefits</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'SSQ')
                                                    <option value="SSQ" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'SSQ')?'selected':''}}>SSQ</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Sun Life Financial')
                                                    <option value="Sun Life Financial" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Sun Life Financial')?'selected':''}}>Sun Life Financial</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'TELUS AdjudiCare')
                                                    <option value="TELUS AdjudiCare" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'TELUS AdjudiCare')?'selected':''}}>TELUS AdjudiCare</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'Union Benefits')
                                                    <option value="Union Benefits" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'Union Benefits')?'selected':''}}>Union Benefits</option>
                                                    @endif
                                                    @if(isset($payment->payment_option_1) && $payment->payment_option_1 != 'UV Insurance')
                                                    <option value="UV Insurance" {{(isset($payment->payment_option_1) && $payment->payment_option_1 == 'UV Insurance')?'selected':''}}>UV Insurance</option>
                                                    @endif
                                                </select>
                                                @error('direct_option_1')
                                                <div id="direct_option_1Help" class="form-text text-danger" id="error_direct_option_1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-3">
                                                <label class="form-label fw-bold">Amount: <span class="text-danger">*</span></label>
                                                <input type="text" name="e_payment_value_1" id="e_payment_value_1" value="{{ $payment->direct_billing_amount_2 ?? '' }}" {{ (!empty($payment))?"disabled":'' }} class="form-control" onkeyup="calculateRemainOnEdit(1);">
                                            </div>
                                        @endif
                                        <div id="remain_div_1" class="d-none"><small>Amount due for this invoice will become</small> $<span id="remain_amt_1"></span></div>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <div class="form-group">
                                            <label for="paid_via" class="form-label fw-bold">Payment Via 2: <span class="text-danger">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="paid_via_2" id="paid_via_2" value="Bank Payment" onclick="enableDisableLevel2(2);" {{(!empty($payment->amount_2) && $payment->amount_2 != 0.00)?"disabled":''}} {{(!empty($payment->payment_via_2))?'checked':''}}>
                                                <label class="form-check-label" for="paid_via_2">
                                                    Bank Payment
                                                </label>
                                            </div>
                                            @error('paid_via_2')
                                            <div id="paid_via_2Help" class="form-text text-danger" id="error_paid_via_2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="payment_option_2" class="form-label fw-bold">Payment Option 2: <span class="text-danger">*</span></label>
                                            <select class="form-select" name="payment_option_2"
                                            id="payment_option_2" onchange="hideShowLevel3(2);" {{(isset($payment->payment_option_2) && $payment->payment_option_2 != '')?'disabled':'disabled'}}>
                                                <option value="">Select</option>
                                                <option value="Credit Card" {{(isset($payment->payment_option_2) && $payment->payment_option_2 == 'Credit Card')?'selected':''}}>Credit Card</option>
                                                <option value="Interac Debit" {{(isset($payment->payment_option_2) && $payment->payment_option_2 == 'Interac Debit')?'selected':''}}>Interac Debit</option>
                                                <option value="Interac E-Transfer" {{(isset($payment->payment_option_2) && $payment->payment_option_2 == 'Interac E-Transfer')?'selected':''}}>Interac E-Transfer</option>
                                                <option value="Gift Card" {{(isset($payment->payment_option_2) && $payment->payment_option_2 == 'Gift Card')?'selected':''}}>Gift Card</option>
                                                <option value="Online" {{(isset($payment->payment_option_2) && $payment->payment_option_2 == 'Online')?'selected':''}}>Online</option>
                                            </select>
                                            @error('payment_option_2')
                                            <div id="payment_option_2Help" class="form-text text-danger" id="error_payment_option_2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-3 {{ (!empty($payment->id) && $payment->amount_2 != 0.00)?'':'d-none' }}" id="pay_div_val_2">
                                            <label class="form-label fw-bold">Amount: <span class="text-danger">*</span></label>
                                            <input type="text" name="payment_value_2" id="payment_value_2" value="{{ (!empty($payment->amount_2) && $payment->amount_2 != 0.00)?$payment->amount_2:'' }}" class="form-control" {{(!empty($payment))?'disabled':''}} onkeyup="calculateRemain(2);">
                                        </div>
                                        @if(!empty($payment) && $payment->amount_2 == 0.00) 
                                            <div class="form-group mt-3">
                                                <label class="form-label fw-bold">Amount: <span class="text-danger">*</span></label>
                                                <input type="text" name="e_payment_value_2" id="e_payment_value_2" value="" {{(!empty($payment))?'disabled':''}} class="form-control" onkeyup="calculateRemainOnEdit(2);">
                                            </div>
                                        @endif
                                        <div id="remain_div_2" class="d-none"><small>Amount due for this invoice will become</small> $<span id="remain_amt_2">50</span></div>
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <div class="form-group">
                                            <label for="paid_via_3" class="form-label fw-bold">Payment Via 3: <span class="text-danger">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="paid_via_3"
                                            id="paid_via_3" value="Cash" onclick="enableDisableLevel2(3);" {{(!empty($payment->amount_3) && $payment->amount_3 != 0.00)?"disabled":''}} {{(!empty($payment->payment_via_3))?'checked':''}}>
                                                <label class="form-check-label" for="paid_via_3">
                                                    Cash
                                                </label>
                                            </div>
                                            @error('paid_via_3')
                                            <div id="paid_via_3Help" class="form-text text-danger" id="error_paid_via_3">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="payment_option_3" class="form-label fw-bold">Payment Option 3: <span class="text-danger">*</span></label>
                                            <select class="form-select" name="payment_option_3"
                                            id="payment_option_3" onchange="hideShowLevel3(3);" {{(isset($payment->payment_option_3))?'disabled':'disabled'}}>
                                                <option value="">Select</option>
                                                <option value="Cash" {{(isset($payment->payment_option_3) && $payment->payment_option_3 == 'Cash')?'selected':''}}>Cash</option>
                                                <option value="Cheque" {{(isset($payment->payment_option_3) && $payment->payment_option_3 == 'Cheque')?'selected':''}}>Cheque</option>
                                                <option value="Gift Card" {{(isset($payment->payment_option_3) && $payment->payment_option_3 == 'Gift Card')?'selected':''}}>Gift Card</option>
                                            </select>
                                            @error('payment_option_3')
                                            <div id="payment_option_3Help" class="form-text text-danger" id="error_payment_option_3">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-3 {{ (!empty($payment->id) && $payment->amount_3 != 0.00)?'':'d-none' }}" id="pay_div_val_3">
                                            <label class="form-label fw-bold">Amount: <span class="text-danger">*</span></label>
                                            <input type="text" name="payment_value_3" id="payment_value_3" value="{{ (!empty($payment->amount_3) && $payment->amount_3 != 0.00)?$payment->amount_3:'' }}" class="form-control" {{(!empty($payment))?'disabled':''}} onkeyup="calculateRemain(3);">
                                        </div>
                                        @if(!empty($payment) && $payment->amount_3 == 0.00) 
                                            <div class="form-group mt-3">
                                                <label class="form-label fw-bold">Amount: <span class="text-danger">*</span></label>
                                                <input type="text" name="e_payment_value_3" id="e_payment_value_3" value="" {{(!empty($payment))?'disabled':''}} class="form-control" onkeyup="calculateRemainOnEdit(3);">
                                            </div>
                                        @endif
                                        <div id="remain_div_3" class="d-none"><small>Amount due for this invoice will become</small> $<span id="remain_amt_3"></span></div>
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <div class="form-group">
                                            <label for="paid_via_4" class="form-label fw-bold">Payment Via 4: <span class="text-danger">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="paid_via_4"
                                            id="paid_via_4" value="Account" onclick="enableDisableLevel2(4);" {{(!empty($payment->amount_4) && $payment->amount_4 != 0.00)?"disabled":''}} {{(!empty($payment->payment_via_4))?'checked':''}}>
                                                <label class="form-check-label" for="paid_via_4">
                                                    Account
                                                </label>
                                            </div>
                                            @error('paid_via_4')
                                            <div id="paid_via_4Help" class="form-text text-danger" id="error_paid_via_4">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="paid_via_4" class="form-label fw-bold">Payment Option 4: <span class="text-danger">*</span></label>
                                            <select class="form-select" name="payment_option_4"
                                            id="payment_option_4" onchange="hideShowLevel3(4);" {{(isset($payment->payment_option_4))?'disabled':'disabled'}}>
                                                <option value="">Select</option>
                                                <option value="Account" {{(isset($payment->payment_option_4) && $payment->payment_option_4 == 'Account')?'selected':''}}>Account</option>
                                                <option value="Credit on file" {{(isset($payment->payment_option_4) && $payment->payment_option_4 == 'Credit on file')?'selected':''}}>Credit on file</option>
                                                <option value="Waived" {{(isset($payment->payment_option_4) && $payment->payment_option_4 == 'Waived')?'selected':''}}>Waived</option>
                                                <option value="Other" {{(isset($payment->payment_option_4) && $payment->payment_option_4 == 'Other')?'selected':''}}>Other</option>
                                            </select>
                                            @error('payment_option_4')
                                            <div id="payment_option_4Help" class="form-text text-danger" id="error_payment_option_4">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-3 {{ (!empty($payment->id) && $payment->amount_4 != 0.00)?'':'d-none' }}" id="pay_div_val_4">
                                            <label class="form-label fw-bold">Amount: <span class="text-danger">*</span></label>
                                            <input type="text" name="payment_value_4" id="payment_value_4" value=" {{ (!empty($payment->amount_4) && $payment->amount_4 != 0.00)?$payment->amount_4:'' }}" class="form-control" {{(!empty($payment))?'disabled':''}} onkeyup="calculateRemain(4);">
                                        </div>
                                        @if(!empty($payment) && $payment->amount_4 == 0.00) 
                                            <div class="form-group mt-3">
                                                <label class="form-label fw-bold">Amount: <span class="text-danger">*</span></label>
                                                <input type="text" name="e_payment_value_4" id="e_payment_value_4"  {{(!empty($payment))?'disabled':'' }} value="" class="form-control" onkeyup="calculateRemainOnEdit(4);">
                                            </div>
                                        @endif
                                        <div id="remain_div_4" class="d-none"><small>Amount due for this invoice will become</small> $<span id="remain_amt_4"></span></div>
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <div class="form-group">
                                            <label for="paid_via_5" class="form-label fw-bold">Payment Via 5: <span class="text-danger">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="paid_via_5"
                                            id="paid_via_5" value="Other Method" onclick="enableDisableLevel2(5);" {{(!empty($payment->amount_5) && $payment->amount_5 != 0.00)?"disabled":''}} {{(!empty($payment->payment_via_5))?'checked':''}}>
                                                <label class="form-check-label" for="paid_via_5">
                                                    Other Method
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="payment_option_5" class="form-label fw-bold">Payment Option 5: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="payment_option_5"
                                            id="payment_option_5" onkeydown="hideShowLevel3(5);" {{(isset($payment->payment_option_5))?'disabled':'disabled'}} value="{{ $payment->payment_option_5 ?? '' }}">
                                            @error('payment_option_5')
                                            <div id="payment_option_5Help" class="form-text text-danger" id="error_payment_option_5">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-3 {{ (!empty($payment->id) && $payment->amount_5 != 0.00)?'':'d-none' }}" id="pay_div_val_5">
                                            <label class="form-label fw-bold">Amount: <span class="text-danger">*</span></label>
                                            <input type="text" name="payment_value_5" id="payment_value_5" value="{{ (!empty($payment->amount_5) && $payment->amount_5 != 0.00)?$payment->amount_5:'' }}" class="form-control" {{(!empty($payment))?'disabled':''}} onkeyup="calculateRemain(5);">
                                        </div>
                                        @if(!empty($payment->id) && $payment->amount_5 == 0.00) 
                                            <div class="form-group mt-3">
                                                <label class="form-label fw-bold">Amount: <span class="text-danger">*</span></label>
                                                <input type="text" name="e_payment_value_5" id="e_payment_value_5" value="" {{(!empty($payment))?'disabled':''}} class="form-control" onkeyup="calculateRemainOnEdit(5);" {{ (!empty($payment->payment_via_5))?'required':'' }}>
                                            </div>
                                        @endif
                                        <div id="remain_div_5" class="d-none"><small>Amount due for this invoice will become</small> $<span id="remain_amt_5"></span></div>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.invoices') }}" id="btnCancel" class="btn btn-danger ms-2">Cancel</a>
                        </div>
                    </div>
                    {{--<div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title fw-bold">Services</div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="row">
                                   
                                </div>
                            </div>
                        </div>
                        
                    </div>--}}

                   
                    {{--end::Footer--}}
                  </form>
                  {{--end::Form--}}
                </div>
            </div>
        </div>
    {{--end::Row--}}

    </div>
    {{--end::Container--}}
</div>
@endsection