@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Create Appointment</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.appointments') }}">Appointments</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Appointment</li>
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
                <form id="frmBookAppointment" action="#">
                    @csrf
                    <div class="card card-info card-outline mb-4">
                        {{--begin::Header--}}
                        <div class="card-header"><div class="card-title fw-bold">Appointment Form</div></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="row">
                                    @php
                                    $setting = getSetting();
                                    @endphp
                                    <div class="col-md-12 mb-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Therapist Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-person-plus"></i></span>
                                                {{-- <input type="text" name="therapist_name" id="therapist_name" class="form-control" value="{{ $setting->therapist_name }}" placeholder="Therapist Name"> --}}
                                                <select name="therapist_id" id="therapist_id" class="form-select">
                                                    @foreach($serv_provider as $val)
                                                    <option value="{{ $val->id }}">{{ $val->first_name.' '.$val->last_name }} - {{ $val->license }}</option>
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
                                                <input type="hidden" name="dependent" value="">
                                                <input type="hidden" name="family_id" value="0">
                                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                                                <input type="text" class="form-control" id="customer_search" value="{{($prev_booking->customer_name)??''}}" placeholder="Enter name or mobile" aria-describedby="customer_idHelp"
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
                                                <input type="text" class="form-control" name="customer_email" value="{{($prev_booking->customer_email)??''}}">
                                                <input type="hidden" name="customer_id" value="{{($prev_booking->customer_id)??''}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Customer Mobile</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-phone"></i></span>
                                                <input type="text" class="form-control" name="customer_mobile" value="{{($prev_booking->customer_mobile)??''}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Appointment Date: <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-calendar3"></i></span>
                                                <input type="text" class="form-control" name="booking_date" id="booking_date" value="{{ !empty($prev_booking->booking_date)?get_formatted_date($prev_booking->booking_date, 'M d, Y') : old('booking_date') }}" aria-describedby="booking_dateHelp" readonly />
                                            </div>
                                            <div id="slot_err"></div>
                                            
                                            @error('booking_date')
                                            <div id="booking_dateHelp" class="form-text text-danger" id="error_booking_date">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="row mt-4">
                                            @php
                                            $all_ser = array_chunk($all_services, 2, true);
                                            @endphp
                                            @forelse($all_ser as $serviceChunk)
                                                @foreach($serviceChunk as $key => $service)
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-4 service-group" data-service-category="{{ $key }}">
                                                            <h6 class="fw-bold">{{ $key }}</h6>
                                                            @foreach($service as $sval)
                                                                <div class="form-check">
                                                                    <input class="form-check-input service-checkbox" type="checkbox" name="services[]" id="services_{{$loop->parent->iteration}}_{{$loop->iteration}}" value="{{ $sval['id'] ?? $sval['service_name'] }}">
                                                                    <label class="form-check-label" 
                                                                        for="services_{{$loop->parent->iteration}}_{{$loop->iteration}}">
                                                                        {{ $sval['service_name'] }}, ${{ $sval['price'] }}
                                                                    </label>
                                                                    <input type="hidden" id="prc_{{$sval['id']}}" value="{{$sval['price']}}">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @empty
                                                <div class="col-12">
                                                    <h6>Services are Not Available</h6>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="invoice_date" class="form-label fw-bold">Appointment Time: <span class="text-danger">*</span></label>
                                            <p id="req_duration"></p>
                                            @php
                                                $setting = getSetting();
                                                $clinic_st = $setting->start_time;
                                                $clinic_ed = $setting->end_time;
                                                $default_duration = $setting->duration;
                                                $allSlots = generateTimeSlots($clinic_st, $clinic_ed, $default_duration);
                                            @endphp
                                            <input type="hidden" id="de_cli_tms" value="{{json_encode($allSlots)}}">
                                            <input type="hidden" id="de_cli_dura" value="{{$default_duration}}">
                                            <input type="hidden" id="de_cli_endtm" value="">
                                            <input type="hidden" id="selected_slots" name="selected_slots">
                                            <div class="row" id="time_slots_div">
                                                @foreach($allSlots as $slot)
                                                    <div class="col-md-4 col-sm-6 mt-2">
                                                        <div class="btn bg-white text-body text-uppercase p-2 w-100" data-value="{{ $slot }}">
                                                            {{ $slot }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="appoit_msg" class="form-label fw-bold">Message</label>
                                            <textarea name="message" id="message" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="btnSubmitAppointment" data-action="confirm" class="btn btn-primary">Submit</button>
                            <button type="submit" id="btnSendForm" name="btnSendForm" data-action="send_form" class="btn btn-primary ms-2">Send Form</button>
                            <button class="btn btn-primary d-none" id="loader" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>
                            <a href="{{ route('admin.appointments') }}" id="btnCancel" class="btn btn-danger ms-2">Cancel</a>
                            
                        </div>
                    </div>
                </form>
                <div id="msg"></div>
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
                        {{-- <div class="col-6 mb-3">
                            <label for="dob" class="form-label">Date of Birth:</label>
                            <div class="input-group" id="u4">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-calendar-check"></i></span>
                                <input type="text" name="dob" id="dob" class="form-control" placeholder="Date of Birth" readonly aria-label="dob" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-dob"></div>
                        </div> --}}
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
                            {{-- <div class="input-group" id="u4">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-calendar-check"></i></span>
                                <input type="text" name="dob" id="dob" class="form-control" placeholder="Date of Birth" readonly aria-label="dob" aria-describedby="basic-addon2">
                            </div> --}}
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