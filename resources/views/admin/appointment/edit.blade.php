@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Edit Appointment</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.appointments') }}">Appointments</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Appointment</li>
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
                <form id="frmUpdateBookAppointment" action="#">
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
                                    <input type="hidden" name="id" value="{{$result->id}}">
                                    <input type="hidden" name="booking_status" value="{{$result->booking_status}}">
                                    <div class="col-md-12 mb-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Therapist Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-person-plus"></i></span>

                                                <select name="therapist_id" id="therapist_id" class="form-select">
                                                    <option value="">Select</option>
                                                    @foreach($all_providers as $val)
                                                    <option value="{{$val->id}}" {{ $val->id == $result->service_provider_id ? 'selected' : '' }}>{{ $val->first_name .' '. $val->last_name }}, {{ $val->license }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="text-danger" id="error_therapist_id"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Customer Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                                                <input type="text" class="form-control" id="customer_search" value="{{$result->customer_name}}" placeholder="Enter name or mobile" aria-describedby="customer_idHelp"
                                                />
                                            </div>
                                            <div class="text-danger" id="error_customer_name"></div>
                                            <div id="customer_suggestions" class="list-group"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Customer Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-envelope-at"></i></span>
                                                <input type="text" class="form-control" name="customer_email" value="{{$result->customer_email}}">
                                                <input type="hidden" name="customer_id" value="{{$result->customer_id}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Customer Mobile</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-phone"></i></span>
                                                <input type="text" class="form-control" name="customer_mobile" value="{{ $result->customer_mobile }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="invoice_date" class="form-label fw-bold">Appointment Date: <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-calendar3"></i></span>
                                                <input type="text" class="form-control" name="booking_date" id="booking_date" value="{{ get_formatted_date($result->booking_date, 'M d, Y') }}" aria-describedby="booking_dateHelp" readonly />
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
                                                            @php
                                                            $selected_services = explode(',', $result->services);
                                                            @endphp
                                                            @foreach($service as $sval)
                                                                <div class="form-check">
                                                                    <input class="form-check-input service-checkbox" type="checkbox" 
                                                                        name="services[]" 
                                                                        id="services_{{$loop->parent->iteration}}_{{$loop->iteration}}" 
                                                                        value="{{ $sval['id'] ?? $sval['service_name'] }}" {{ (in_array($sval['id'], $selected_services)) ? 'checked':'' }}>
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
                                            <label class="form-label fw-bold">Appointment Time: <span class="text-danger">*</span></label>
                                            <p id="req_duration"></p>
                                            @php
                                                $setting = getSetting();
                                                $all_slots = array_filter(explode(",", $all_slots_str));
                                                $current_booking_slots = array_filter(explode(",", $current_slots_str));
                                                $booked_slots = array_filter(explode(',', $other_booked_str));
                                                $blocked_slots_array = array_filter(explode(',', $blocked_slots_str));
                                                $lunch_slots_array = array_filter(explode(',', $lunch_slots_str));
                                            @endphp
                                            <input type="hidden" id="de_cli_tms" value="{{json_encode($all_slots)}}">
                                            <input type="hidden" id="de_cli_dura" value="{{$setting->duration}}">
                                            <input type="hidden" id="de_cli_endtm" value="">
                                            <div class="row" id="time_slots_div">
                                            @forelse($all_slots as $slot)
                                                @php
                                                $isLunch = in_array($slot, $lunch_slots_array);

                                                $isBlocked = in_array($slot, $blocked_slots_array);

                                                $isBooked = in_array($slot, $current_booking_slots);

                                                $is_other_booked = in_array($slot, $booked_slots);

                                                @endphp
                                                @if($isBooked) 
                                                    @php
                                                    $class = 'slot_brd disable_slots engaged';
                                                    $title = 'Already Booked';
                                                    @endphp
                                                
                                                @elseif($isBlocked) 
                                                    @php
                                                    $class = 'slot_brd blocked_slot';
                                                    $title = 'Slots are blocked by Admin'
                                                    @endphp
                                                @elseif($is_other_booked)
                                                    @php
                                                    $class = 'slot_brd other_disable_slots engaged';
                                                    $title = 'Already Booked By Others';
                                                    @endphp
                                                @elseif($isLunch)
                                                    @php
                                                    $class = 'slot_brd lunch_slot';
                                                    $title = 'Lunch Time';
                                                    @endphp
                                                @else
                                                    @php
                                                    $class = 'slot_brd';
                                                    $title = 'Available';
                                                    @endphp
                                                @endif
                                                <div class="col-md-4 col-sm-6 mt-2">
                                                    <div class="btn {{$class}} bg-white text-body text-uppercase p-2 w-100" data-value="{{ trim($slot) }}" data-lunch="{{$isLunch ? 1 : 0}}" data-blocked="{{$isBlocked ? 1 : 0}}" data-current-booked="{{ $isBooked ? 1 : 0 }}" data-other-booked="{{ $is_other_booked ? 1 : 0 }}" data-duration="{{$required_duration}}" title="{{$title}}">
                                                        {{ trim($slot) }}
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-12">
                                                    <p>No time slots available for this date.</p>
                                                </div>
                                            @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group mb-5">
                                            <label for="appoit_msg" class="form-label fw-bold">Message</label>
                                            <textarea name="message" id="message" class="form-control">{{ ($result->message) ?? '' }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="appoit_msg" class="form-label fw-bold">Booking Status</label>
                                            <select name="booking_status" id="booking_status" class="form-select">
                                                <option value="">Select</option>
                                                <option value="pending" {{ ($result->booking_status == 'pending')?'selected':'' }}>Pending</option>
                                                <option value="confirmed" {{ ($result->booking_status == 'confirmed')?'selected':'' }}>Confirmed</option>
                                                <option value="completed" {{ ($result->booking_status == 'completed')?'selected':'' }}>Completed</option>
                                                <option value="canceled" {{ ($result->booking_status == 'canceled')?'selected':'' }}>Canceled</option>
                                                <option value="declined" {{ ($result->booking_status == 'declined')?'selected':'' }}>Declined</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="btnSubmitAppointment" class="btn btn-primary">Submit</button>
                            <button class="btn btn-primary d-none" id="loader" type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
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
@endsection