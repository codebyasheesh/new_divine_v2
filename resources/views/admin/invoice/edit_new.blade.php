@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Edit Invoice</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.invoices') }}">Invoices</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Invoice</li>
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
                  <form action="{{ route('admin.save_edit_invoice') }}" method="post">
                    @csrf
                    {{--begin::Header--}}
                    {{-- <input type="hidden" name="booking_id" value="{{$data->id}}"> --}}
                    <div class="card card-outline card-primary collapsed-card mb-4">
                    <div class="card-header"><h3 class="card-title fw-bold">Business address and contact details and logo</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                    </div>
                    {{--end::Header--}}
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{asset('admin_assets/assets/img/divine-logo.png')}}" class="img-fluid" />
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    <input type="hidden" name="customer_id" value="{{$data->customer_id}}">
                                    <input type="hidden" name="customer_name" value="{{$data->customer_name}}">

                                    <h2 class="text-end">Invoice</h2>
                                    <h4 class="text-end">Divine Touch Therapy</h4>
                                    <div class="text-end">70 Twistleton St,<br />Caledon, ON L7C 4B5,<br/>Telephone : +1 905-996-2700<br />Email : info@divinetouchtherapy.com</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--begin::Footer--}}
                    {{-- <div class="card-footer">&nbsp;</div> --}}
                    </div>
                    {{--end::Footer--}}
                    <div class="card card-info card-outline mb-4">
                    {{--begin::Header--}}
                        <div class="card-header"><div class="card-title fw-bold">Customer Invoice</div></div>
                        <div class="card-body">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Therapist Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-plus"></i></span>
                                            <input type="text" name="therapist_name" id="therapist_name" class="form-control" value="{{ $data->therapist_name }}" placeholder="Therapist Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Therapist Licence No.</label>
                                        <div class="input-group">
                                           <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                            <input type="text" name="therapist_license" id="therapist_license" class="form-control" value="{{ $data->therapist_license }}" placeholder="Therapy Licence">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Customer Name</label>
                                        <input type="text" class="form-control" id="customer_search" value="{{$data->customer_name}}" placeholder="Enter name or mobile" aria-describedby="customer_idHelp"
                                            />
                                        <div id="customer_suggestions" class="list-group"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Customer Mobile</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon2"><i class="bi bi-phone"></i></span>
                                            <input type="text" class="form-control" name="customer_mobile" value="{{ $data->customer_mobile }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Customer Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon2"><i class="bi bi-envelope-at"></i></span>
                                            <input type="text" class="form-control" name="customer_email" value="{{ $data->customer_email }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <div class="form-group">
                                        <label for="invoice_date" class="form-label fw-bold">Invoice Date: <span class="text-danger">*</span></label>
                                        <input
                                        type="text"
                                        class="form-control" name="invoice_date"
                                        id="invoice_date" value="{{ get_formatted_date($data->invoice_date, 'M d, Y')?? date('M d, Y') }}" aria-describedby="invoice_dateHelp" />
                                        
                                        @error('invoice_date')
                                        <div id="invoice_dateHelp" class="form-text text-danger" id="error_invoice_date">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-md-6 mt-4">
                                    <div class="gorm-group">
                                        <label for="payment_due_date" class="form-label fw-bold">Payment Due Date: <span class="text-danger">*</span></label>
                                        <input
                                        type="text"
                                        class="form-control" name="payment_due_date"
                                        id="payment_due_date" value="{{ get_formatted_date($data->payment_due, 'd-M-Y')?? old('payment_due_date') }}"
                                        aria-describedby="payment_due_dateHelp"
                                        />
                                        @error('payment_due_date')
                                        <div id="payment_due_dateHelp" class="form-text text-danger" id="error_payment_due_date">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}
                            </div>
                            
                        </div>
                        
                        </div>
                    </div>
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title fw-bold">Services</div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="row">
                                    <table class="table table-bordered" id="services_table">
                                        <thead>
                                            <tr>
                                                <th>Service</th>
                                                <th>Duration</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                                <th><button type="button" class="btn btn-sm btn-success" id="add_row">+</button></th>
                                            </tr>
                                        </thead>
                                        <tbody id="services_body">
                                            @for($i = 0; $i < count($service_ids); $i++)
                                            <tr>
                                                <td>
                                                    <select name="service_id[]" id="service_id_{{ $i }}" class="form-select" onchange="getServicePrice('{{$i}}');">
                                                        <option value="">Select Service</option>
                                                        @foreach($services as $val)
                                                            <option value="{{ $val->id }}" {{($val->id == $service_ids[$i])?'selected':''}}>{{ $val->service_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <div id="duration_{{ $i }}">{{$duration[$i]}} Min<input type="hidden" name="duration" value="{{$duration[$i]}}"></div>
                                                </td>
                                                <td>1</td>
                                                <td>
                                                    <div id="row_total_div_{{$i}}">$<span id="spn_row_total_{{$i}}">{{$data->ser_pri[$i]}}</span></div>
                                                    <input type="hidden" name="row_total[]" id="row_total_{{ $i }}" value="{{$data->ser_pri[$i]}}">
                                                    <input type="hidden" name="is_taxable[]" id="is_taxable_{{ $i }}">
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            @endfor
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="card card-success card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title fw-bold">Calculation</div>
                        </div>
                        @php
                        $tax = getSetting();
                        @endphp
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    {{-- <div class="row mb-2">
                                        <div class="col-6">
                                        <label>Discount Type:</label>
                                        <select name="discount_type" id="discount_type" class="form-select">
                                            <option value="none" {{($data->discount_type == 'none')?'selected':''}}>None</option>
                                            <option value="flat" {{($data->discount_type == 'flat')?'selected':''}}>Flat</option>
                                            <option value="percentage" {{($data->discount_type == 'percentage')?'selected':''}}>Percentage</option>
                                        </select>
                                        </div>
                                        <div class="col-6">
                                        <label>Discount:</label>
                                        <input type="number" class="form-control" name="discount" id="discount" min="0" value="{{$data->discount_type_val}}" onkeyup="calculateDiscount();">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label>Notes:</label>
                                            <input type="text" class="form-control" name="notes" id="notes" value="{{$data->notes}}">
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="col-6">
                                <div class="row">
                                    <div class="col-7 fw-bold text-end mt-1">Sub Total:</div>
                                    <div class="col-5 text-end">
                                    <input type="hidden" name="subtotal" id="subtotal" value="{{$data->subtotal}}">
                                    <div class="mt-1"><span>$</span><span id="spn_sub_tot">{{$data->subtotal}}</span></div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-7 fw-bold text-end mt-1">Discount:</div>
                                    <div class="col-5 text-end">
                                    <div class="mt-1"><span>$</span><span id="spn_discount">{{$data->discount_value}}</span><input type="hidden" name="discount_val" value="{{$data->discount_value}}"></div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-7 fw-bold text-end mt-1">Tax:</div>
                                    <div class="col-5 text-end">
                                    &nbsp;
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-7 text-end mt-1"><small>{{$tax->tax_name}} ({{$tax->tax_value.'%'}}):</small></div>
                                    <div class="col-5 text-end">
                                        <div class="mt-1"><span>$</span><span id="spn_hst">{{$data->hst_tax}}</span><input type="hidden" name="hst_val" value="{{$data->hst_tax}}"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-7 fw-bold text-end mt-1">Grand Total:</div>
                                    <div class="col-5 text-end">
                                        <div class="mt-1">
                                            <span>$</span><span id="spn_grand_total" class="fw-bold">{{$data->final_amount}}</span>
                                            <input type="hidden" name="grand_total" value="{{$data->final_amount}}">
                                        </div>
                                    </div>
                                </div>
                                
                                <!--<div class="row">
                                    <div class="col-7 fw-bold text-end mt-1">Note:</div>
                                    <div class="col-5 text-end">
                                    <div class="mt-1"><input type="text" class="form-control" name="notes" id="notes" value=""></div>
                                    </div>
                                </div>-->
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.invoices') }}" id="btnCancel" class="btn btn-danger ms-2">Cancel</a>
                        </div>
                    </div>
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