@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Block Time By Day Schedule</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.day.time.schedule') }}">Schedules</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Schedule</li>
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
                <form id="frmAddSchedule" action="#">
                    @csrf
                    <div class="card card-info card-outline mb-4">
                        {{--begin::Header--}}
                        <div class="card-header"><div class="card-title fw-bold">Schedule Form</div></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="row">
                                    @php
                                    $setting = getSetting();
                                    @endphp
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="invoice_date" class="form-label fw-bold">Select The Day: <span class="text-danger">*</span></label>
                                            <select name="day" id="day" class="form-select">
                                                <option value="">Select</option>
                                                <option value="Monday">Monday</option>
                                                <option value="Tuesday">Tuesday</option>
                                                <option value="Wednesday">Wednesday</option>
                                                <option value="Thursday">Thursday</option>
                                                <option value="Friday">Friday</option>
                                                <option value="Saturday">Saturday</option>
                                                <option value="Sunday">Sunday</option>
                                            </select>
                                            
                                            @error('day')
                                            <div id="dayHelp" class="form-text text-danger" id="error_day">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="invoice_date" class="form-label fw-bold">Choose the Time slot to be Blocked: <span class="text-danger">*</span></label>
                                            <p id="req_duration"></p>
                                            <div class="row" id="block_avail_time_div">
                                                @php
                                                    $morningSlots = generateTimeSlots('09:30', '14:00');
                                                    $eveningSlots = generateTimeSlots('16:00', '19:00');
                                                    $allSlots = array_merge($morningSlots, $eveningSlots);
                                                @endphp
                                                
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
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="btnSchedule" class="btn btn-primary">Submit</button>
                            <button class="btn btn-primary d-none" id="loader" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                        </div>
                    </div>
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