@extends('admin.layouts.app')

@section('content')
<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Block Time Slots List</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.block_date_time') }}">Schedule</a></li>
            <li class="breadcrumb-item active" aria-current="page">Block Time Slots List</li>
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
                        {{-- <h3 class="card-title">Services</h3> --}}
                        
                        <div class="d-flex justify-content-start">
                            <a href="{{ route('admin.add_blockdatetime') }}" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Add Block Date Time" role="button"><i class="bi bi-plus-circle"></i> Add Block date Time </a>
                        </div>
                        
                    </div>
                    {{-- /.card-header --}}
                    <div class="card-body">
                    {{-- <table class="table table-striped table-sm" id="dateblock-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Time Slots</th>
                            <th style="width: 40%;">Block Dates</th>
                            <th>Day</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table> --}}
                        <div class="" id="calendar"></div>
                    </div>
                    {{-- /.card-body --}}
                </div>
            </div>
        </div>
    {{--end::Row--}}

    </div>
    {{--end::Container--}}
</div>

{{-- Unblock Dates popup --}}
<div class="modal fade" id="unBlockModelPop" tabindex="-1" aria-labelledby="unBlockModelPopLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unBlockModelPopLabel">UnBlock Dates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmUnblockPopup" id="frmUnblockPopup" action="javascript:void(0);">
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="id" id="id" value="">
                        <label for="name" class="form-label">Dates</label>
                        <div id="blocked_dts">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="unblock_timeslot('frmUnblockPopup');" id="btnUnblock"
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
{{-- End Unblock Dates popup --}}
@endsection