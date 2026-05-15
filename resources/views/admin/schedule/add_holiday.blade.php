@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Block Holiday Date Time Schedule</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.day.time.schedule') }}">Schedules</a></li>
            <li class="breadcrumb-item active" aria-current="page">Block Holiday Schedule</li>
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
                {{-- <form id="frmAddHoliday" action="#">
                    @csrf
                    <div class="card card-info card-outline mb-4">

                        <div class="card-header"><div class="card-title fw-bold">Block Holiday Date Time Schedule</div></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Select The Date: <span class="text-danger">*</span></label>
                                            <div class="input-daterange input-group" id="datepicker">
                                                <input type="text" class="input-sm form-control" name="start_dt" />
                                                <span class="input-group-addon" style="min-width: 16px; padding: 6px 10px; line-height: 1.42857143; border-width: 1px 0; background-color:#f5f2f2">to</span>
                                                <input type="text" class="input-sm form-control" name="end_dt" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Holiday Name</label>
                                            <input type="text" name="holiday_name" id="holiday_name" class="form-control" required>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="btnHoliday" class="btn btn-primary">Submit</button>
                            <button class="btn btn-primary d-none" id="loader" type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </div>
                </form> --}}
                
                {{--end::Form--}}
            </div>
        </div>
    </div>
    {{--end::Row--}}
</div>
    {{--end::Container--}}
</div>
@endsection