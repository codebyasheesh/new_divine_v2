@extends('admin.layouts.app')

@section('content')
<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Past Appointments</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Past Appointments</li>
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
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-3">
                                <a href="{{ route('admin.add.appointment') }}" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Add Appointment"
                            role="button"><i class="bi bi-plus-circle"></i> Add</a>
                            </div>
                            <div class="col-3 text-end mt-1">
                                <label class="form-label fw-bold">Date Range:</label>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    {{-- <label class="form-label fw-bold">Date Range</label> --}}
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="input-sm form-control" placeholder="From" id="app_st" />
                                        <span class="input-group-addon" style="min-width: 16px; padding: 6px 10px; line-height: 1.42857143; border-width: 1px 0; background-color:#f5f2f2">to</span>
                                        <input type="text" class="input-sm form-control" placeholder="to" id="app_ed" />
                                        <button class="btn btn-sm btn-primary" id="pastAppointmentDateFilter" data-bs-toggletip="tooltip" data-bs-title="Date Range Filter" role="button"><i class="bi bi-search"></i> Filter</button>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    {{-- /.card-header --}}
                    <div class="card-body">
                        <table class="table table-striped table-sm" id="past-appointment-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Time/ Date</th>
                                    <th>Duration</th>
                                    <th>Services</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    {{-- /.card-body --}}
                </div>
            </div>
        </div>
    {{--end::Row--}}
    </div>
    {{--end::Container--}}
</div>



{{-- Edit Appointment Detail Popup --}}
<div class="modal fade" id="appointmentDetailPop" tabindex="-1" aria-labelledby="varyingAppointmentDetailLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingAppointmentDetailLabel">Appointment Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-4 col-form-label fw-bold">Customer Detail</label>
                        <div class="col-8">
                            <div id="spn_name"></div>
                            <div id="spn_email"></div>
                            <div id="spn_mobile"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-4 col-form-label fw-bold">Services</label>
                        <div class="col-8">
                            <div class="col-form-label" id="spn_services"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-4 col-form-label fw-bold">Date/ Time</label>
                        <div class="col-8">
                            <div class="col-form-label" id="spn_date"></div>
                            <div class="col-form-label" id="spn_time"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-4 col-form-label fw-bold">Status</label>
                        <div class="col-8">
                            <div class="col-form-label" id="spn_status"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-4 col-form-label fw-bold">Total Amount</label>
                        <div class="col-8">
                            <div class="col-form-label" id="spn_amount"></div>
                        </div>
                    </div>
                   
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{-- Edit Service Popup End --}}
@endsection