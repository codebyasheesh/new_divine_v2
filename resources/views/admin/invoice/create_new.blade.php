@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Fresh Invoice</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.invoices') }}">Invoices</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Invoice</li>
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
                  @php
                    $setting = getSetting();
                    @endphp
                  {{--begin::Alert--}}
                  {{--begin::Form--}}
                  <form id="frmUnlinkedInvoice" action="{{ route('admin.save_unlinked_invoice') }}" method="post">
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

                                    <input type="hidden" name="customer_id" value="">
                                    <input type="hidden" name="customer_name" value="">
                                    

                                    <h2 class="text-end">Invoice</h2>
                                    <h4 class="text-end">{{ $setting->company_name }}</h4>
                                    <div class="text-end">{{ $setting->company_address }},<br/>Telephone : {{ substr($setting->company_phone, 0, 3).'-'.substr($setting->company_phone, 3, 3).'-'.substr($setting->company_phone, 6, 4) }}<br />Email : {{ $setting->company_email }}</div>
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
                        <div class="card-header">
                            <div class="card-title fw-bold">Customer Invoice</div>
                            {{-- <span class="card-title ps-2">{{newGenerateInvoiceNumber()}}</span> --}}
                            {{-- <div class="row">
                                <div class="col-2">
                                    <span class="fw-bold">Next Invoice No#: </span>
                                </div>
                                <div class="col-3">
                                    <span id="toggleinvbox" data-bs-toggletip="tooltip" data-bs-title="Click to change the invoice number" style="cursor: pointer;">{{generateInvoiceNumber()}}</span>
                                    <input type="text" name="invoice_number" id="invoice_number" class="form-control col-sm-4" style="display:none;" value="" placeholder="Enter Invoice Number">
                                </div>
                                <div class="col-3">
                                    <button type="button" id="btnToggleInv" class="btn btn-primary btn-sm">Use Custom Invoice No#</button>
                                </div>
                            </div> --}}
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <div class="form-group">
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Therapist Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-person-plus"></i></span>
                                                {{-- <input type="text" name="therapist_name" id="therapist_name" class="form-control" value="{{ $setting->therapist_name }}" placeholder="Therapist Name"> --}}
                                                <select name="therapist_id" id="therapist_id" class="form-select">
                                                    <option value="">Select</option>
                                                    @foreach($provider as $val)
                                                    <option value="{{ $val->id }}">{{ $val->first_name.' '.$val->last_name }}, {{ $val->license }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Therapist Licence No.</label>
                                            <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                                <input type="text" name="therapist_license" id="therapist_license" class="form-control" value="{{ $setting->therapist_license }}" placeholder="Therapy Licence">
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Customer Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                                                <input type="text" class="form-control" id="customer_search" value="" placeholder="Enter name or mobile" aria-describedby="customer_idHelp"
                                                />
                                            </div>
                                            <div id="customer_suggestions" class="list-group"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Customer Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-envelope-at"></i></span>
                                                <input type="text" class="form-control" name="customer_email" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Customer Mobile</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-phone"></i></span>
                                                <input type="text" class="form-control" name="customer_mobile" value="">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="invoice_date" class="form-label fw-bold">Invoice Date: <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-calendar3"></i></span>
                                                <input type="text" class="form-control" name="invoice_date" id="invoice_date" value="{{ old('invoice_date', date('M d, Y')) }}" aria-describedby="invoice_dateHelp" />
                                            </div>
                                            @error('invoice_date')
                                            <div id="invoice_dateHelp" class="form-text text-danger" id="error_invoice_date">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
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
                                            @php
                                            $index = 0;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <select name="service_id[]" id="service_id_{{ $index }}" class="form-select" onchange="getServicePrice('{{$index}}');">
                                                        <option value="">Select Service</option>
                                                        @foreach($services as $val)
                                                            <option value="{{ $val->id }}">{{ $val->service_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                
                                                <td>
                                                    <div id="duration_{{ $index }}"></div>
                                                </td>
                                                <td>1</td>
                                                
                                                <td>
                                                    <div id="row_total_div_{{$index}}">$<span id="spn_row_total_{{$index}}">0</span></div>
                                                    <input type="hidden" name="row_total[]" id="row_total_{{ $index }}">
                                                    <input type="hidden" name="is_taxable[]" id="is_taxable_{{ $index }}">
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
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
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                
                                </div>
                                <div class="col-6">
                                <div class="row">
                                    <div class="col-7 fw-bold text-end mt-1">Sub Total:</div>
                                    <div class="col-5 text-end">
                                    <input type="hidden" name="subtotal" id="subtotal" value="">
                                    <div class="mt-1"><span>$</span><span id="spn_sub_tot"></span></div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-7 fw-bold text-end mt-1">Tax:</div>
                                    <div class="col-5 text-end">
                                    &nbsp;
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-7 text-end mt-1"><small>{{$setting->tax_name}} ({{$setting->tax_value.'%'}}):</small></div>
                                    <div class="col-5 text-end">
                                        <div class="mt-1"><span>$</span><span id="spn_hst"></span><input type="hidden" name="hst_val" value=""></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-7 fw-bold text-end mt-1">Grand Total:</div>
                                    <div class="col-5 text-end">
                                        <div class="mt-1">
                                            <span>$</span><span id="spn_grand_total" class="fw-bold"></span>
                                            <input type="hidden" name="grand_total" value="">
                                        </div>
                                    </div>
                                </div>
                               
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="submit" name="submit_pay" class="btn btn-success ms-2" value="yes">Submit & Record Payment</button>
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

{{-- Add User PopUp --}}
<div class="modal fade" id="addUserPop" tabindex="-1" aria-labelledby="varyingUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingUserLabel">Add Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmAddUser" id="frmAddUser" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <input type="hidden" name="is_primary" value="1">
                            <label for="name" class="form-label">First Name</label>
                            <div class="input-group" id="u1">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" maxlength="40">
                            </div>
                            <div class="text-danger ms-5 error-first_name"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="name" class="form-label">Last Name</label>
                            <div class="input-group" id="u1">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" maxlength="40">
                            </div>
                            <div class="text-danger ms-5 error-last_name"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <div class="input-group" id="u2">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-envelope-at"></i></span>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-email"></div>
                        </div>
                        
                        <div class="col-6 mb-3">
                            <label for="mobile" class="form-label">Mobile:</label>
                            <div class="input-group" id="u3">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-phone"></i></span>
                                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile" maxlength="12" aria-label="Mobile" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-mobile"></div>
                        </div>
                        <div class="col-9 mb-3">
                            <label for="dob" class="form-label">Date of Birth:</label>
                            <div class="row">
                                <div class="col-sm-4">
                                    @php
                                        $currentYear = date('Y');
                                        $startYear = $currentYear - 80; // 100 years ago
                                    @endphp
                                    <select name="byear" id="byear" class="form-select" onchange="setDaysCount(document.getElementById('bmonth').value, 'bday', 'byear');">
                                        <option value="">Year</option>
                                        @foreach(range($currentYear, $startYear) as $year)
                                            <option value="{{ $year }}">
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select name="bmonth" id="bmonth" class="form-select" onchange="setDaysCount(this.value, 'bday', 'byear');">
                                        <option value="">Month</option>
                                        @foreach(range(1, 12) as $month)
                                            <option value="{{ $month }}">
                                                {{ $month }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select name="bday" id="bday" class="form-select">
                                        <option value="">Date</option>
                                    </select>
                                </div>
                            </div>
                            <div class="text-danger ms-5 error-dob"></div>
                        </div>
                        <div class="col-3 mb-3">
                            <label for="gender" class="form-label">Gender:</label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                                
                            </select>
                            <div class="text-danger ms-5 error-gender"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Address:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-geo-alt"></i></span>
                                <textarea name="address" id="address" class="form-control" placeholder="Address" maxlength="80" aria-label="Address" aria-describedby="basic-addon2"></textarea>
                            </div>
                            <div class="text-danger ms-5 error-e_address"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="city" class="form-label">City:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" name="city" id="city" class="form-control" placeholder="City" maxlength="80" aria-label="City" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-e_city"></div>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="state" class="form-label">State:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" name="state" id="state" class="form-control" placeholder="State" maxlength="30" aria-label="state" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-e_state"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="postal_code" class="form-label">Postal Code:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-mailbox"></i></span>
                                <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Postal Code" maxlength="10" aria-label="Postal Code" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-e_postal_code"></div>
                        </div>
                        
                        <div class="col-6 mb-3">
                            <label for="remark" class="form-label">Remark:</label>
                            <textarea name="remark" id="remark" class="form-control" placeholder="Remark"></textarea>
                            
                            <div class="text-danger ms-5 error-remark"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="addUserAction('frmAddUser')" id="btnLog"
                        class="btn btn-primary">Save</button>
                    <button class="btn btn-primary d-none" id="loader" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Add User PopUp End --}}
@endsection