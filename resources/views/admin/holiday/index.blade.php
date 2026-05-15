@extends('admin.layouts.app')

@section('content')
<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Holiday List</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Holiday</li>
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

                        <div class="d-flex justify-content-start">
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Add New Client" data-bs-toggle="modal" data-bs-target="#addHolidayPop" data-bs-whatever="addHolidayPop"
                        role="button"><i class="bi bi-plus-circle"></i> Add Holiday</a>
                        </div>
                    </div>
                    {{-- /.card-header --}}
                    <div class="card-body">
                    <table class="table table-striped table-sm" id="holidaylist-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Holiday Name</th>
                            <th>Range</th>
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
{{-- Add User PopUp --}}
<div class="modal fade" id="addHolidayPop" tabindex="-1" aria-labelledby="varyingHolidayLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingHolidayLabel">Add Holiday</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmAddHoliday" id="frmAddHoliday" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="name" class="form-label">Holiday Name</label>
                            <div class="input-group" id="u1">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-pen"></i></span>
                                <input type="text" class="form-control" name="holiday_name" id="holiday_name" placeholder="Holiday Name" maxlength="100">
                            </div>
                            <div class="text-danger ms-5 error-holiday_name"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="name" class="form-label">Range</label>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="input-sm form-control" name="start_dt" readonly />
                                <span class="input-group-addon" style="min-width: 16px; padding: 6px 10px; line-height: 1.42857143; border-width: 1px 0; background-color:#f5f2f2">to</span>
                                <input type="text" class="input-sm form-control" name="end_dt" readonly />
                            </div>
                            <div class="text-danger ms-5 error-range"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="addHolidayAction('frmAddHoliday')" id="btnHoliday"
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

{{-- Edit User Popup --}}
<div class="modal fade" id="editHolidayPop" tabindex="-1" aria-labelledby="varyingEditHolidayLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingEditHolidayLabel">Edit Holiday</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmEditHoliday" id="frmEditHoliday" action="javascript:void(0);" method="POST">
                <input type="hidden" name="id" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <input type="hidden" name="e_id" value="">
                            <label for="holiday_name" class="form-label">Holiday Name</label>
                            <div class="input-group" id="eu1">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="holiday_name" id="e_holiday_name" placeholder="Holiday Name" maxlength="100">
                            </div>
                            <div class="text-danger ms-5 e-error-holiday_name"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="range" class="form-label">Range</label>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="input-sm form-control" name="start_dt" id="e_sdt" readonly />
                                <span class="input-group-addon" style="min-width: 16px; padding: 6px 10px; line-height: 1.42857143; border-width: 1px 0; background-color:#f5f2f2">to</span>
                                <input type="text" class="input-sm form-control" name="end_dt" id="e_edt" readonly />
                            </div>
                            <div class="text-danger ms-5 e-error-last_name"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="editHolidayAction('frmEditHoliday')" id="e_btnHoliday"
                        class="btn btn-primary">Save</button>
                    <button class="btn btn-primary d-none" id="e_loader" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Edit Holiday Popup End --}}
@endsection