@extends('admin.layouts.app')

@section('content')
<style>
    ul.bill_to {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }
</style>
<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    @php
        $setting = getSetting();
    @endphp
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">View Invoice</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.invoices') }}">Invoices</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Invoice</li>
        </ol>
        </div>
    </div>
    {{--end::Row--}}
    </div>
    {{--end::Container--}}
</div>
{{--end::App Content Header--}}
{{--begin::App Content--}}
<div class="app-content">
    {{--begin::Container--}}
    <div class="container-fluid">
    {{--begin::Row--}}
        <div class="row">
            <div class="col-12" id="print_div">
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-lg-4"><img src="{{asset('admin_assets/assets/img/divine-touch-logo2.png')}}" class="img-fluid" style="width: 150px;" /></div>
                                    <div class="col-lg-8 d-flex flex-column justify-content-end">
                                        <div><strong>Therapist: </strong>{{ $data->therapist_name }}</div>
                                        <div><strong>License: </strong>{{ $data->therapist_license }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <h2 class="text-end">Invoice</h2>
                                <h4 class="text-end">{{ $setting->company_name }}</h4>
                                <div class="text-end">{{ $setting->company_address }},<br/>Telephone : {{ substr($setting->company_phone, 0, 3).'-'.substr($setting->company_phone, 3, 3).'-'.substr($setting->company_phone, 6, 4) }}<br />Email : {{ $setting->company_email }}</div>
                            </div>
                        </div>
                    </div>
                    {{-- /.card-header --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <h6 class="ps-1">Bill to</h6>
                                @php
                                $cty = '';
                                $stat = '';
                                $postal_cod = '';
                                $addr = $data->address ?? $data->p_address;
                                @endphp
                                @if(!empty($data->city)) 
                                @php
                                    $comm = ($addr) ? ', ':'';
                                    $cty = $comm.$data->city;
                                @endphp

                                @elseif(empty($data->city) && !empty($data->p_city))
                                @php
                                $comm = ($addr) ? ', ':'';
                                $cty = $comm . $data->p_city;
                                @endphp
                                @endif

                                @if(!empty($data->state)) 
                                @php
                                    $comm = ($cty) ? ', ':'';
                                    $stat = $comm.$data->state;
                                @endphp

                                @elseif(empty($data->state) && !empty($data->p_state))
                                @php
                                $stat = $comm . $data->p_state;
                                @endphp
                                @endif

                                @if(!empty($data->postal_code)) 
                                @php
                                    $comm = ($stat) ? ', ':'';
                                    $postal_cod = $comm.$data->postal_code;
                                @endphp

                                @elseif(empty($data->postal_code) && !empty($data->p_postal_code))
                                @php
                                $postal_cod = $comm . $data->p_state;
                                @endphp
                                @endif

                                @php
                                $comp_addr = $addr.$cty.$stat.$postal_cod;
                                @endphp

                                <ul class="ps-1" style="list-style-type: none;">
                                    <li class="fw-bold">{{ucwords($data->customer_name) }}</li>

                                    <li>{{ $comp_addr }}</li>
                                    <li>&nbsp;</li>
                                    <li>{{ $data->customer_mobile }}</li>
                                    <li>{{ $data->customer_email }}</li>
                                </ul>
                            </div>
                            <div class="col-3">
                                &nbsp;
                            </div>
                            <div class="col-4">
                                <ul class="ms-lg-5" style="list-style-type: none;">
                                    <li><strong>Invoice No: </strong>{{$data->invoice_number}}</li>
                                    <li><strong>Date: </strong>{{get_formatted_date($data->invoice_date, 'M d, Y')}}</li>
                                    {{-- <li><strong>Due Date: </strong>{{get_formatted_date($data->payment_due, 'F d, Y')}}</li> --}}
                                    <li>
                                        @if(isset($data->payment->paid_amount))
                                        @php
                                            $total_paid = $data->payment->paid_amount;
                                        @endphp
                                        @else
                                        @php
                                        $total_paid = 0;
                                        @endphp
                                        @endif
                                        @php
                                        
                                        // $total_paid = $data->payment->paid_amount;
                                        $amount_due = $data->final_amount - $total_paid;
                                        @endphp
                                        <strong>Payment Due: ${{ number_format($amount_due, 2) }}</strong></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr style="background-color: #f7ad29; color: #000;">
                                        <th style="background-color: #f7ad29; color: #000;">Service</th>
                                        <th style="background-color: #f7ad29; color: #000;">Duration</th>
                                        <th style="background-color: #f7ad29; color: #000;">Qty</th>
                                        <th style="background-color: #f7ad29; color: #000;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=0;   
                                    @endphp
                                    @foreach($data->service_details as $key => $val)
                                    <tr>
                                        <td> {{$val->service_name}}</td>
                                        <td>{{$val->duration}}</td>
                                        <td>1</td>
                                        <td>{{$ser_prices[$key]}}</td>
                                    </tr>
                                    @php 
                                    $i++
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-8 col-6">&nbsp;</div>
                            <div class="col-lg-4 col-6">
                                <div class="row">
                                    <div class="col-7 fw-bold text-end">Sub Total:</div>
                                    <div class="col-5 text-end pe-lg-5">
                                    <div class=""><span>$</span><span id="spn_sub_tot">{{$data->subtotal}}</span></div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-7 fw-bold text-end">Discount:</div>
                                    <div class="col-5 text-end pe-lg-5">
                                        <div class=""><span>$</span><span id="spn_discount">{{$data->discount_value}}</span></div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-7 fw-bold text-end">Tax (<small>{{$setting->tax_name}} {{$setting->tax_value}}%</small>):</div>
                                    <div class="col-5 text-end pe-lg-5">
                                     <div class=""><span>$</span><span id="spn_tax">{{$data->hst_tax}}</span></div>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-7 fw-bold text-end">Total:</div>
                                    <div class="col-5 text-end pe-lg-5">
                                        <div class=""><span>$</span><span id="total" class="fw-bold">{{number_format($data->final_amount, 2)}}</span>
                                        </div>
                                    </div>
                                </div>
                                @if(!empty($data->payment->amount_1) && $data->payment->amount_1 != 0.00) 
                                <div class="row">
                                    <div class="col-7 text-end">Via {{$data->payment->payment_option_1 ?? 'Direct Billing'}}:</div>
                                    <div class="col-5 text-end pe-lg-5">
                                        <div class=""><span>$</span><span id="total">{{ number_format($data->payment->amount_1, 2) }}</span>
                                        </div>
                                    </div>
                                    @if(!empty($data->payment->direct_billing_option_2))
                                    <div class="col-7 text-end">Via {{$data->payment->direct_billing_option_2 ?? ''}}:</div>
                                    <div class="col-5 text-end pe-lg-5">
                                        <div class=""><span>$</span><span id="total">{{ number_format($data->payment->direct_billing_amount_2, 2) }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @endif

                                @if(!empty($data->payment->amount_2) && $data->payment->amount_2 != 0.00)
                                <div class="row">
                                    <div class="col-7 text-end">Via {{(!empty($data->payment->payment_option_2)) ? $data->payment->payment_option_2 : 'Bank Payment'}}:</div>
                                    <div class="col-5 text-end pe-lg-5">
                                        <div class="">
                                            <span>$</span><span id="total">{{ number_format($data->payment->amount_2, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($data->payment->amount_3) && $data->payment->amount_3 != 0.00)
                                <div class="row">
                                    <div class="col-7 text-end">Via {{(!empty($data->payment->payment_option_3)) ? $data->payment->payment_option_3 : 'Cash'}}:</div>
                                    <div class="col-5 text-end pe-lg-5">
                                        <div class="">
                                            <span>$</span><span id="total">{{number_format($data->payment->amount_3, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($data->payment->amount_4) && $data->payment->amount_4 != 0.00)
                                <div class="row">
                                    {{-- <div class="col-7 text-end">Payment using {{$data->payment->payment_option_4}}:</div> --}}
                                    <div class="col-7 text-end">Payment:</div>
                                    <div class="col-5 text-end pe-lg-5">
                                        <div class="">
                                            <span>$</span><span id="total">{{ number_format($data->payment->amount_4, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(($data->payment) && ($data->payment->amount_5 != 0.00))
                                <div class="row">
                                    <div class="col-7 text-end">Via {{(!empty($data->payment->payment_option_5)) ? $data->payment->payment_option_5 : $data->payment->payment_via_5}}:</div>
                                    <div class="col-5 text-end pe-lg-5">
                                        <div class="">
                                            <span>$</span><span id="total">{{ number_format($data->payment->amount_5, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <hr />
                                <div class="row">
                                    <div class="col-7 fw-bold text-end">Amount Due:</div>
                                    <div class="col-5 text-end pe-lg-5">
                                    <div class=""><span>$</span><span id="due" class="fw-bold">{{number_format($amount_due, 2)}}</span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                @php $setting = getSetting(); @endphp
                                <label class="fw-bold">Notes/ Terms</label>
                                <p>{{ $setting->notes }}<br>{{ $setting->terms }}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-center text-secondary">
                                <strong>HST Reg # </strong>{{ $setting->hst_registration_no }}
                            </div>
                        </div>
                    </div>
                    {{-- /.card-body --}}
                </div>
            </div>
            <div class="col-12 text-center">
                <a href="javascript:void(0);" onclick="printInvoice('print_div');" class="btn btn-warning btn-sm"><i class="bi bi-printer"></i> Print Invoice</a>
                <a href="{{ route('admin.download.invoice', $data->id) }}" class="btn btn-success btn-sm"><i class="bi bi-download"></i> Download Invoice</a>
            </div>
        </div>
    {{--end::Row--}}

    </div>
    {{--end::Container--}}
</div>

@endsection