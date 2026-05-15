@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Block Date Time Schedule</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.block_date_time') }}">Schedules</a></li>
            <li class="breadcrumb-item active" aria-current="page">Block Schedule</li>
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
                <form id="frmAddDateTimeBlock" action="#">
                    @csrf
                    <div class="card card-info card-outline mb-4">
                        {{--begin::Header--}}
                        <div class="card-header"><div class="card-title fw-bold">Block Date Time Schedule</div></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-12 mt-4">
                                        <div class="form-group">
                                            <label for="txtDate" class="form-label fw-bold">Select The Date: <span class="text-danger">*</span></label>
                                            <input type="text" name="txtDate" id="txtDate" class="form-control" placeholder="Select a Date" readonly>
                                            @error('txtDate')
                                            <div id="txtDateHelp" class="form-text text-danger" id="error_day">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12 mt-4">
                                        <div class="form-group">
                                            <label for="invoice_date" class="form-label"><span class="fw-bold">Choose the Time slot to be Blocked: </span><span class="text-danger">*</span> (<small>With <span class="text-danger">Red</span> Background Box are <em>blocked</em> on <b>selected date</b>.</small>)</label>
                                            <p id="req_duration"></p>
                                            <div class=""><a href="javascript:void(0);" class="btn btn-primary btn-sm" id="selectAllTimeSlots">Select All</a></div>
                                            <div class="row" id="block_avail_time_div">
                                                @php
                                                    $morningSlots = generateTimeSlots('09:30', '13:30');
                                                    $eveningSlots = generateTimeSlots('16:00', '19:00');
                                                    $allSlots = array_merge($morningSlots, $eveningSlots);
                                                @endphp
                                                
                                                @foreach($allSlots as $slot)
                                                    <div class="col-md-4 col-sm-6 mt-2">
                                                        <div class="btn time_brd bg-white text-body text-uppercase p-2 w-100" data-value="{{ $slot }}" data-duration="30">
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
                            <button type="submit" id="btnBlockDtTm" class="btn btn-primary">Submit</button>
                            <button class="btn btn-primary d-none" id="loader" type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                            <a href="{{ route('admin.block_date_time') }}" id="btnCancel" class="btn btn-danger ms-2">Cancel</a>
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