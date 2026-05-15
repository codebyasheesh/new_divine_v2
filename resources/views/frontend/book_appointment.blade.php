@extends('frontend.layouts.app')

@section('content')
@push('styles')
<style>
/* Force scrollbar visibility for slot container */
.slot-scroll {
    scrollbar-width: thin;          /* Firefox */
}

.slot-scroll::-webkit-scrollbar {
    width: 8px;                     /* Chrome, Edge, Safari */
}

.slot-scroll::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 4px;
}

.slot-scroll::-webkit-scrollbar-track {
    background-color: #f1f1f1;
}
</style>
@endpush
    <div class="section-padding">
        <div class="row">
            <div class="col-xl-2 col-lg-1 d-none d-lg-block"></div>
            <div class="col-xl-8 col-lg-10">
                <div class="appointment-tab-form p-3 bg-white box-shadow">
                    <div class="row g-3">
                        <div class="col-lg-4">
                            <ul
                            id="appointment-tab-list"
                            class="bg-primary p-4 list-inline m-0 d-flex justify-content-lg-between justify-content-center h-100 flex-lg-column"
                            >
                                <li class="active mb-lg-3 me-lg-0 me-sm-3 me-2" id="step_1_tab">
                                    <a href="javascript:void(0);" class="d-inline-block">
                                    <span class="d-flex gap-3">
                                        <span
                                        class="tab-position text-center pe-lg-0 pe-sm-4 pe-3"
                                        >
                                        <span class="d-inline-block active-circle"> </span>
                                        </span>
                                        <span class="tab-content d-lg-block d-none">
                                        <span class="tab-title d-block mb-1">
                                            Services
                                        </span>
                                        <span class="tab-desc">
                                            Please select a service from available options
                                        </span>
                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="mb-lg-3 me-lg-0 me-sm-3 me-2" id="step_2_tab">
                                    <a href="javascript:void(0);" class="d-inline-block">
                                    <span class="d-flex gap-3">
                                        <span
                                        class="tab-position text-center pe-lg-0 pe-sm-4 pe-3"
                                        >
                                        <span class="d-inline-block active-circle"></span>
                                        </span>
                                        <span class="tab-content d-lg-block d-none">
                                        <span class="tab-title d-block mb-1">
                                            Select Date and Time
                                        </span>
                                        <span class="tab-desc">
                                            Select date to see available timeslots
                                        </span>
                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="mb-lg-3 me-lg-0 me-sm-3 me-2" id="step_3_tab">
                                    <a href="javascript:void(0);" class="d-inline-block">
                                    <span class="d-flex gap-3">
                                        <span
                                        class="tab-position text-center pe-lg-0 pe-sm-4 pe-3"
                                        >
                                        <span class="d-inline-block active-circle"> </span>
                                        </span>
                                        <span class="tab-content d-lg-block d-none">
                                        <span class="tab-title d-block mb-1">
                                            Your Details
                                        </span>
                                        <span class="tab-desc">
                                            Please provide your contact details
                                        </span>
                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="mb-lg-3 me-lg-0 me-sm-3 me-2" id="step_4_tab">
                                    <a href="javascript:void(0);" class="d-inline-block">
                                    <span class="d-flex gap-3">
                                        <span
                                        class="tab-position text-center pe-lg-0 pe-sm-4 pe-3"
                                        >
                                        <span class="d-inline-block active-circle"> </span>
                                        </span>
                                        <span class="tab-content d-lg-block d-none">
                                        <span class="tab-title d-block mb-1">
                                            Special Request
                                        </span>
                                        <span class="tab-desc">
                                            Specify detail if any
                                        </span>
                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li id="step_5_tab">
                                    <a href="javascript:void(0);" class="d-inline-block">
                                    <span class="d-flex gap-3">
                                        <span class="tab-position text-center">
                                        <span class="d-inline-block active-circle"></span>
                                        </span>
                                        <span class="tab-content d-lg-block d-none">
                                        <span class="tab-title d-block mb-1">
                                            Send Request
                                        </span>
                                        <span class="tab-desc"> Submit the form to send appointment request </span>
                                        </span>
                                    </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-8 mt-lg-3 mt-5">
                            <div class="border h-100 position-relative">
                            <div class="appointment-content-active h-100" id="step_1">
                                <div class="tab-widget-inner h-100">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 py-3 mx-3 border-bottom">
                                    <h5 class="mb-0 flex-shrink-0">Select Service</h5>
                                </div>
                                @php
                                $setting = getSetting();
                                @endphp
                                <div class="tab-widget-inner-data pt-5 pb-3 px-3 slot-scroll" style="height:400px; overflow-y:scroll; overflow-x:hidden;">
                                    <div class="row">
                                        @php
                                            $massageServiceIds = [9, 12, 13]; // Massage 60, 45, 30
                                            $massageAddOnIds = [45];  // Massage Add-on Service
                                            $skinAddOnIds = [20];
                                            $microniddlingAddOnIds = [60];
                                        @endphp
                                        @forelse($all_services as $key => $service)
                                            <div class="text-start">{{$key}}</div>
                                            @foreach($service as $sval)
                                                @if($loop->first)
                                                <div class="col-sm-4">
                                                    <div
                                                    class="form-check form-check-inline m-0 p-0 position-relative d-block box-checked">
                                                    <input
                                                        type="checkbox"
                                                        name="services[]"
                                                        class="form-check-input service-checkbox"
                                                        id="services_{{$loop->parent->iteration}}_{{$loop->iteration}}" data-group="{{ in_array($sval['id'], $massageServiceIds) ? 'massage' : '' }}" value="{{$sval['id']}}" />
                                                    <label
                                                        class="form-check-label d-inline-block overflow-hidden w-100"
                                                        for="services_{{$loop->parent->iteration}}_{{$loop->iteration}}">
                                                        <span class="d-block p-4 text-center position-relative">
                                                        <span class="d-block mb-3 position-relative">
                                                        </span>
                                                        <span class="d-block h6 fw-500 mt-3 mb-1" id="nmspan_{{$sval['id']}}">{{ $sval['service_name'] }}</span>
                                                        <span class="text-body" id="prc_{{$sval['id']}}">$ {{number_format($sval['price'], 2)}}</span>
                                                        </span>
                                                    </label>
                                                    </div>
                                                </div>
                                                @elseif($sval['id'] != 14 && $sval['id'] != 15 && $sval['id'] != 32)
                                                    @php
                                                        $initi_dis = '';
                                                    @endphp
                                                    @if($sval['id'] == 45) 
                                                        @php
                                                        $initi_dis = 'disabled';
                                                        @endphp
                                                    @endif
                                                <div class="col-sm-4 mt-sm-0 mt-4">
                                                    <div
                                                    class="form-check form-check-inline m-0 p-0 position-relative d-block box-checked"
                                                    >
                                                    <input
                                                        type="checkbox"
                                                        name="services[]"
                                                        class="form-check-input service-checkbox"
                                                        id="services_{{$loop->parent->iteration}}_{{$loop->iteration}}" data-group="{{ in_array($sval['id'], $massageServiceIds) ? 'massage' : '' }}{{in_array($sval['id'], $massageAddOnIds) ? 'massage_addon' : ''}}" value="{{$sval['id']}}" {{ $initi_dis }} />
                                                    <label
                                                        class="form-check-label d-inline-block overflow-hidden w-100"
                                                        for="services_{{$loop->parent->iteration}}_{{$loop->iteration}}">
                                                        <span
                                                        class="d-block p-4 text-center position-relative">
                                                        <span
                                                            class="d-block mb-3 position-relative">
                                                        </span>
                                                        <span class="d-block h6 fw-500 mt-3 mb-1" id="nmspan_{{$sval['id']}}">{{$sval['service_name']}}</span>
                                                        <span class="text-body" id="prc_{{$sval['id']}}">${{number_format($sval['price'], 2)}}</span>
                                                        </span>
                                                    </label>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        @empty
                                        <div class="col-sm-4">
                                            <div
                                            class="form-check form-check-inline m-0 p-0 position-relative d-block box-checked">
                                            <label
                                                class="form-check-label d-inline-block overflow-hidden w-100">
                                                <span
                                                class="d-block p-4 text-center position-relative">
                                                <span class="d-block h6 fw-500 mt-3 mb-1"
                                                    >Services are Not Available</span>
                                                </span>
                                            </label>
                                            </div>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                                <div
                                    class="d-flex align-items-center justify-content-end px-3 mb-3 mt-3 gap-3">
                                    <button
                                    type="button"
                                    name="next"
                                    class="bg-primary iq-button text-capitalize next"
                                    value="Next" id="chkSevDur">
                                    <span class="iq-btn-text-holder position-relative"
                                        >Next</span
                                    >
                                    <span class="iq-btn-icon-holder">
                                        <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="10"
                                        height="10"
                                        viewBox="0 0 8 8"
                                        fill="none"
                                        >
                                        <path
                                            d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                            fill="currentColor"
                                        ></path>
                                        </svg>
                                    </span>
                                    </button>
                                </div>
                                </div>
                            </div>
                            <div
                                class="appointment-tab-content h-100 appointment-content-active" id="step_2">
                                <div class="tab-widget-inner h-100">
                                <div class="py-5 mx-3 border-bottom">
                                    <h5 class="mb-0">Select Date and Time</h5>
                                </div>
                                <div class="tab-widget-inner-data pt-5 pb-3 px-3 slot-scroll" style="height:480px; overflow-y:scroll; overflow-x:hidden;">
                                    <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mb-0">
                                        <input
                                            type="hidden"
                                            name="appointment_dt"
                                            id="appointment_dt"
                                            class="d-none inline_flatpickr" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-sm-0 mt-4">
                                        <div class="p-3 bg-primary-subtle">
                                            <p id="valid_err"></p>
                                            <p id="early_date"></p>
                                            <p id="req_duration"></p>
                                            @php
                                                $setting = getSetting();
                                                $clinic_st = $setting->start_time;
                                                $clinic_ed = $setting->end_time;
                                                $default_duration = $setting->duration;
                                                $allSlots = generateTimeSlots($clinic_st, $clinic_ed, $default_duration);
                                            @endphp
                                            <input type="hidden" id="de_cli_tms" value="{{json_encode($allSlots)}}">
                                            <input type="hidden" id="de_cli_dura" value="{{$setting->duration}}">
                                            <input type="hidden" id="de_cli_endtm" value="">
                                            <input type="hidden" id="selected_slots" name="selected_slots">
                                            <div class="row gx-1" id="time_slots_div">
                                            

                                            @foreach($allSlots as $slot)
                                                <div class="col-md-4 col-sm-6 mt-3">
                                                    <div class="btn bg-white text-body text-uppercase p-2 w-100 blank" data-value="{{ $slot }}">
                                                        {{ $slot }}
                                                    </div>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-end px-3 mb-3 mt-3 gap-3">
                                    <button
                                    type="button"
                                    name="Previous" id="back_to_service"
                                    class="iq-button text-capitalize back"
                                    value="Previous"
                                    >
                                    <span class="iq-btn-text-holder position-relative"
                                        >Previous</span
                                    >
                                    <span class="iq-btn-icon-holder">
                                        <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="10"
                                        height="10"
                                        viewBox="0 0 8 8"
                                        fill="none">
                                        <path
                                            d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                            fill="currentColor"
                                        ></path>
                                        </svg>
                                    </span>
                                    </button>
                                    <button
                                    type="button"
                                    name="next"
                                    class="bg-primary iq-button text-capitalize next"
                                    value="Next" id="btn_tm_dt"
                                    >
                                    <span class="iq-btn-text-holder position-relative"
                                        >Next</span>
                                    <span class="iq-btn-icon-holder">
                                        <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="10"
                                        height="10"
                                        viewBox="0 0 8 8"
                                        fill="none">
                                        <path
                                            d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                            fill="currentColor"></path>
                                        </svg>
                                    </span>
                                    </button>
                                </div>
                                </div>
                            </div>
                            <div
                                class="appointment-tab-content h-100 appointment-content-active" id="step_3">
                                <div class="tab-widget-inner h-100">
                                <div class="py-3 mx-3 border-bottom">
                                    <h5 class="mb-0">Enter Details</h5>
                                </div>
                                <div class="tab-widget-inner-data pt-5 pb-3 px-3">
                                    <div class="row h-100">
                                        <div class="col-12">
                                            @auth

                                            <ul class="nav nav-tabs mb-0" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button
                                                    class="nav-link active"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#register"
                                                    type="button"
                                                    role="tab"
                                                    aria-controls="register"
                                                    aria-selected="true"
                                                    >
                                                    Select Customer Detail
                                                    </button>
                                                </li>
                                            </ul>

                                            <div class="tab-content h-100">
                                                <div class="tab-pane fade show active h-100" id="register" role="tabpanel" aria-labelledby="register">
                                                    <div class="py-5 px-4 bg-primary-subtle h-100">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <label class="form-label h6"
                                                                >Select Member</label
                                                                >
                                                                <select class="form-select" aria-label="Default select example" name="customer" id="customer">
                                                                    <option value="">Select Member</option>
                                                                    @foreach ($members as $member)
                                                                        <option value="{{ $member['id'] }}">{{ $member['first_name'].' '.$member['last_name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <ul class="nav nav-tabs mb-0" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button
                                                    class="nav-link active"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#register"
                                                    type="button"
                                                    role="tab"
                                                    aria-controls="register"
                                                    aria-selected="true"
                                                    >
                                                    Customer Detail
                                                    </button>
                                                </li>
                                                {{-- <li class="nav-item" role="presentation">
                                                    <button
                                                    class="nav-link"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#login"
                                                    type="button"
                                                    role="tab"
                                                    aria-controls="login"
                                                    aria-selected="false"
                                                    >
                                                    Login
                                                    </button>
                                                </li> --}}
                                            </ul>

                                            <div class="tab-content h-100">
                                                <div class="tab-pane fade show active h-100" id="register" role="tabpanel" aria-labelledby="register">
                                                    <div class="py-5 px-4 bg-primary-subtle h-100">
                                                        {{-- <form> --}}
                                                        <div class="row">
                                                            <div class="col-sm-6 mt-3">
                                                                <label class="form-label h6">Email *</label>
                                                                <input type="email" id="email" name="booking_frm_email" class="form-control" placeholder="Enter Your Email" required="" />
                                                            </div>
                                                            <div class="col-sm-6 mt-3">
                                                                <label class="form-label h6">Mobile *</label>
                                                                <input type="text" id="mobile" class="form-control" placeholder="Enter Your Mobile" required="" maxlength="12" />
                                                            </div>
                                                            <div class="col-sm-6 mt-3">
                                                                <label class="form-label h6">First Name *</label>
                                                                <input type="text" id="f_name" class="form-control" placeholder="Enter Your First Name" required="" readonly />
                                                            </div>
                                                            <div class="col-sm-6 mt-3">
                                                                <label class="form-label h6">Last Name *</label>
                                                                <input type="text" id="l_name" class="form-control" placeholder="Enter Your Last Name" required="" readonly />
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <label class="form-label h6">Gender <small>(Optional)</small></label>
                                                                <div class="d-flex align-items-center flex-wrap gap-3">
                                                                    <div class="form-check">
                                                                        <input type="radio" name="gender" class="form-check-input" id="male" value="Male" />
                                                                        <label class="form-check-label h6" for="male">Male</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input type="radio" name="gender" class="form-check-input" id="female" value="Female" />
                                                                        <label class="form-check-label h6" for="female">Female</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input type="radio" name="gender" class="form-check-input" id="other" value="Other" />
                                                                        <label class="form-check-label h6" for="other">Other</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <label class="form-label h6">DOB <small>(Optional)</small></label>
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        @php
                                                                            $currentYear = date('Y');
                                                                            $startYear = $currentYear - 80; // 100 years ago
                                                                        @endphp
                                                                        <select id="dob_y" class="form-select" onchange="setDaysCount(document.getElementById('dob_m').value, 'dob_d', this.value);">
                                                                            <option value="">Year</option>
                                                                            @foreach(range($currentYear, $startYear) as $year)
                                                                                <option value="{{ $year }}">
                                                                                    {{ $year }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        @php
                                                                        $mnth = ['01'=>'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];
                                                                        @endphp
                                                                        <select id="dob_m" class="form-select" onchange="setDaysCount(this.value, 'dob_d', 'dob_y');" required="">
                                                                            <option value="">Month</option>
                                                                            @foreach(range(1, 12) as $month)
                                                                            @php
                                                                                $formattedMonth = sprintf('%02d', $month);
                                                                            @endphp
                                                                                <option value="{{ $formattedMonth }}">
                                                                                    {{ $mnth[$formattedMonth] }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <select id="dob_d" class="form-select">
                                                                            <option value="">Date</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        {{-- </form> --}}
                                                    </div>
                                                </div>
                                                {{-- <div class="tab-pane fade h-100" id="login" role="tabpanel" aria-labelledby="login">
                                                    <div class="py-5 px-4 bg-primary-subtle h-100">
                                                    <form>
                                                        <div class="row">
                                                        <div class="col-sm-6">
                                                            <label class="form-label h6"
                                                            >Username or Email *</label>
                                                            <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Enter Your Username or Email"
                                                            required=""
                                                            />
                                                        </div>
                                                        <div class="col-sm-6 mt-sm-0 mt-3">
                                                            <label class="form-label h6"
                                                            >Password *</label
                                                            >
                                                            <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="************"
                                                            required=""
                                                            />
                                                        </div>
                                                        </div>
                                                    </form>
                                                    </div>
                                                </div> --}}
                                            </div>
                                            @endauth
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                    <div
                                        class="d-flex align-items-center justify-content-end px-3 mb-3 mt-3 gap-3">
                                        <button
                                        type="button"
                                        name="Previous"
                                        class="iq-button text-capitalize back"
                                        value="Previous" id="descPrev">
                                        <span class="iq-btn-text-holder position-relative"
                                            >Previous</span>
                                        <span class="iq-btn-icon-holder">
                                            <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="10"
                                            height="10"
                                            viewBox="0 0 8 8"
                                            fill="none">
                                            <path
                                                d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                                fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        </button>
                                        <button
                                        type="button"
                                        name="next" id="step_3_btn"
                                        class="bg-primary iq-button text-capitalize next"
                                        value="Next">
                                        <span class="iq-btn-text-holder position-relative"
                                            >Next</span>
                                        <span class="iq-btn-icon-holder">
                                            <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="10"
                                            height="10"
                                            viewBox="0 0 8 8"
                                            fill="none">
                                            <path
                                                d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                                fill="currentColor"
                                            ></path>
                                            </svg>
                                        </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="appointment-tab-content h-100 appointment-content-active" id="step_4">
                                <div class="tab-widget-inner h-100">
                                    <div class="py-3 mx-3 border-bottom">
                                        <h5 class="mb-0">Confirmation Detail</h5>
                                    </div>
                                    <div class="tab-widget-inner-data pt-5 pb-3 px-3 slot-scroll" style="height:400px; overflow-y:scroll; overflow-x:hidden;">
                                        <div class="row">
                                        <div class="col-sm-6">
                                            <h6
                                            class="text-secondary mb-3 fw-500 text-uppercase"
                                            >
                                            Clinic Info
                                            </h6>
                                            <div class="p-4 bg-primary-subtle">
                                            <h6 class="mb-2">{{$setting->company_name}}</h6>
                                            <p class="m-0 text-body">
                                                {{$setting->company_address}}
                                            </p>
                                            </div>
                                            <h6
                                            class="text-secondary mt-5 mb-3 fw-500 text-uppercase"
                                            >
                                            Patient Info
                                            </h6>
                                            <div class="p-4 bg-primary-subtle">
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                    <tbody>
                                                        <tr>
                                                        <td class="p-0 border-0">
                                                            <h6 class="mb-2">Name:</h6>
                                                        </td>
                                                        <td class="p-0 border-0">
                                                            <p class="mb-2 ps-2 text-start" id="cust_nm"></p>
                                                            <input type="hidden" name="customer" id="customer">
                                                            <input type="hidden" name="cust_nm_hdn" value="" id="cust_nm_hdn" />
                                                            <input type="hidden" name="cust_email_hdn" value="" id="cust_email_hdn" />
                                                            <input type="hidden" name="cust_mob_hdn" value="" id="cust_mob_hdn" />
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        <td class="p-0 border-0">
                                                            <h6 class="mb-2">Number:</h6>
                                                        </td>
                                                        <td class="p-0 border-0">
                                                            <p class="mb-2 ps-2 text-start" id="cust_mob"></p>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        <td class="p-0 border-0">
                                                            <h6 class="mb-0">Email:</h6>
                                                        </td>
                                                        <td class="p-0 border-0">
                                                            <p class="mb-0 ps-2 text-start" id="cust_email"></p>
                                                        </td>
                                                        </tr>
                                                    </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-sm-0 mt-5">
                                            <h6
                                            class="text-secondary mb-3 fw-500 text-uppercase" id="summary_title">
                                            Appointment Summary
                                            </h6>
                                            <div class="p-4 border">
                                            <div class="table-responsive">
                                                <table class="table mb-0">
                                                <tbody>
                                                    <tr>
                                                    <td class="p-0 border-0">
                                                        <p class="mb-2">Therapist:</p>
                                                    </td>
                                                    <td class="p-0 border-0">
                                                        <h6 class="mb-2 ps-2 text-start">
                                                        {{$provider->first_name.' '.$provider->last_name}}
                                                        </h6>
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                    <td class="p-0 border-0">
                                                        <p class="mb-2">Date:</p>
                                                    </td>
                                                    <td class="p-0 border-0">
                                                        <h6 class="mb-2 ps-2 text-start" id="booking_dt">
                                                        
                                                        </h6>
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                    <td class="p-0 border-0">
                                                        <p class="mb-0">Time:</p>
                                                    </td>
                                                    <td class="p-0 border-0">
                                                        <h6 class="mb-0 text-start" id="booking_slots_h6">
                                                        </h6>
                                                    </td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                            </div>
                                            <div class="p-4 bg-primary-subtle mt-4">
                                                <h6 class="mb-2">Selected Services</h6>
                                                <div
                                                class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                        <tbody id="show_choose_services">
                                                        </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex align-items-center justify-content-between flex-wrap gap-3 mt-4">
                                                <h5 class="m-0">Total Price</h5>
                                                <p class="m-0 text-primary" id="price_lbl"></p>
                                                <input type="hidden" name="total_price" id="total_price" value="" />
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    
                                    <div
                                        class="d-flex align-items-center justify-content-end px-3 mb-3 mt-3 gap-3">
                                        <button
                                        type="button"
                                        name="Previous" id="frmPrev"
                                        class="iq-button text-capitalize back"
                                        value="Previous"
                                        >
                                        <span class="iq-btn-text-holder position-relative"
                                            >Previous</span>
                                        <span class="iq-btn-icon-holder">
                                            <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="10"
                                            height="10"
                                            viewBox="0 0 8 8"
                                            fill="none"
                                            >
                                            <path
                                                d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                                fill="currentColor"
                                            ></path>
                                            </svg>
                                        </span>
                                        </button>
                                        <button
                                        type="button"
                                        name="next"
                                        class="bg-primary iq-button text-capitalize next"
                                        value="Next">
                                        <span class="iq-btn-text-holder position-relative"
                                            >Next</span>
                                        <span class="iq-btn-icon-holder">
                                            <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="10"
                                            height="10"
                                            viewBox="0 0 8 8"
                                            fill="none">
                                            <path
                                                d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="appointment-tab-content h-100 appointment-content-active" id="step_5">
                                <div class="tab-widget-inner h-100">
                                <div class="py-3 mx-3 border-bottom">
                                    <h5 class="mb-0">Any Special Request?</h5>
                                </div>
                                <div class="tab-widget-inner-data pt-5 pb-3 px-3 slot-scroll" style="height:280px; overflow-y:scroll; overflow-x:hidden;">
                                        {{-- <form> --}}
                                    <label class="form-label h6">Provide Description (optional)</label>
                                    <textarea class="form-control" required="" id="message" maxlength="150"></textarea>
                                </div>
                                <div class="">
                                    <small>
                                        <ul>
                                            <li>Please note that your appointment is not confirmed until you have received your confirmation via email and/or text message.</li>
                                            <li>Any changes or cancellations require a minimum 24-hour notice. Please read through our <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#privacyPopUp">company policies here</a>.</li>
                                        </ul>
                                    </small>
                                </div>
                                <div
                                    class="d-flex align-items-center justify-content-end px-3 mb-3 mt-3 gap-3">
                                    <button
                                    type="button"
                                    name="Previous"
                                    class="iq-button text-capitalize back"
                                    value="Previous">
                                    <span class="iq-btn-text-holder position-relative"
                                        >Previous</span>
                                    <span class="iq-btn-icon-holder">
                                        <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="10"
                                        height="10"
                                        viewBox="0 0 8 8"
                                        fill="none"
                                        >
                                        <path
                                            d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                            fill="currentColor"
                                        ></path>
                                        </svg>
                                    </span>
                                    </button>
                                    <button
                                    type="button"
                                    name="next"
                                    class="bg-primary iq-button text-capitalize confirm-button" onclick="confirm_appointment();"
                                    value="Next">
                                    <span class="iq-btn-text-holder position-relative" id="fnl_btn"
                                        >Confirm</span>
                                    <span class="iq-btn-icon-holder">
                                        <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="10"
                                        height="10"
                                        viewBox="0 0 8 8"
                                        fill="none"
                                        >
                                        <path
                                            d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                            fill="currentColor"
                                        ></path>
                                        </svg>
                                    </span>
                                    </button>
                                    <div id="loadingOverlay" class="loading-overlay">
                                        <div class="loading-content">
                                            <div class="loading-spinner"></div>
                                            <h3>Processing Your Booking</h3>
                                            <p>Please do not refresh the page or use the back button</p>
                                            <p class="loading-subtext">This may take a few moments...</p>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div
                                class="appointment-tab-content h-100 appointment-content-active" id="step_7">
                                <div class="tab-widget-inner h-100">
                                <div
                                    class="tab-widget-inner-data py-5 px-3 h-100 d-flex align-items-center justify-content-center">
                                    <div class="row">
                                    <div class="col-sm-12">
                                        <div class="text-center">
                                            <div class="mb-5 text-success" id="success_icon">
                                                <svg
                                                class="checkmark-animated"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 52 52"
                                                data-v-6b4a22d6="">
                                                <circle
                                                    class="checkmark__circle"
                                                    cx="26"
                                                    cy="26"
                                                    r="25"
                                                    fill="none"
                                                    data-v-6b4a22d6=""></circle>
                                                <path
                                                    class="checkmark__check"
                                                    fill="none"
                                                    d="M14.1 27.2l7.1 7.2 16.7-16.8"
                                                    data-v-6b4a22d6=""></path>
                                                </svg>
                                            </div>
                                            <div class="fail_icon"></div>
                                            <h4 id="booking_res_h4"></h4>
                                            <p class="mt-4">You will receive your booking confirmation once it's reviewed & verified.</p>
                                            <p>Thank you for booking with us! We value your trust and confidence in our services.</p>
                                            {{-- <p>Please check your email for verification</p> --}}
                                        </div>
                                        <div
                                        class="d-flex align-items-center justify-content-center gap-3 flex-wrap mt-5"
                                        >
                                        <a
                                            href="{{ route('book_appointment')}}"
                                            class="bg-primary iq-button text-capitalize">
                                            <span
                                            class="iq-btn-text-holder position-relative"
                                            >Book More Appointments</span>
                                            <span class="iq-btn-icon-holder">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="8"
                                                height="8"
                                                viewBox="0 0 8 8"
                                                fill="none">
                                                <path
                                                d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                                fill="currentColor"
                                                ></path>
                                            </svg>
                                            </span>
                                        </a>
                                        {{-- <a
                                            href="javascript:void(0);"
                                            class="iq-button text-capitalize">
                                            <span
                                            class="iq-btn-text-holder position-relative"
                                            >Print Detail</span>
                                            <span class="iq-btn-icon-holder">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="8"
                                                height="8"
                                                viewBox="0 0 8 8"
                                                fill="none">
                                                <path
                                                d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                                fill="currentColor"
                                                ></path>
                                            </svg>
                                            </span>
                                        </a>
                                        <a
                                            href="javascript:void(0);"
                                            class="bg-primary iq-button text-capitalize">
                                            <span
                                            class="iq-btn-text-holder position-relative"
                                            >Add To Calendar</span
                                            >
                                            <span class="iq-btn-icon-holder">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="8"
                                                height="8"
                                                viewBox="0 0 8 8"
                                                fill="none">
                                                <path
                                                d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                                fill="currentColor"
                                                ></path>
                                            </svg>
                                            </span>
                                        </a> --}}
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-1 d-none d-lg-block"></div>
        </div>
    </div>
@endsection