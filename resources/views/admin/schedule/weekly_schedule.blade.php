@extends('admin.layouts.app')

@section('content')
<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Weekly Schedules</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Schedules</li>
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
                    {{-- <div class="card-header">
                       
                        <div class="d-flex justify-content-start">
                            <a href="{{ route('admin.add_schedule') }}" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Add Schedule" role="button"><i class="bi bi-plus-circle"></i> Add or Edit </a>
                        </div>
                    </div> --}}
                    {{-- /.card-header --}}
                    <div class="card-body">
                    <table class="table table-striped table-sm" id="weeklyschedule-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Day</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Lunch Start</th>
                            <th>Lunch End</th>
                            <th>is Closed</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $val)
                            @php
                            $open = '<div><span class="badge text-bg-success">Open</span></div>';
                            $closed = '<div><span class="badge text-bg-danger">Closed</span></div>';
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ getDayName($val->day_of_week) }}</td>
                                <td>{{ (!empty($val->start_time))?get_formatted_date($val->start_time, 'h:i A'):'N/A' }}</td>
                                <td>{{ (!empty($val->end_time))?get_formatted_date($val->end_time, 'h:i A'):'N/A' }}</td>
                                <td>{{ (!empty($val->lunch_start))?get_formatted_date($val->lunch_start, 'h:i A'):'N/A' }}</td>
                                <td>{{ (!empty($val->lunch_end))?get_formatted_date($val->lunch_end, 'h:i A') : 'N/A' }}</td>
                                <td>{!! ($val->is_closed == 1)?$closed:$open !!}</td>
                                <td><a href="javascript:void(0);" data-bs-toggletip="tooltip" data-bs-title="Edit Weekly Schedule" data-bs-toggle="modal" data-bs-target="#editWeeklySchedulePop" data-bs-whatever="editWeeklySchedulePop" onclick="editWeeklySchedule({{$val->id}});" class="btn btn-primary btn-sm me-2"><i class="bi bi-pencil"></i> Edit</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                        
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

{{-- Edit Weekly Schedule Popup --}}
<div class="modal fade" id="editWeeklySchedulePop" tabindex="-1" aria-labelledby="varyingEditWeeklySchedulePop">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingEditServiceProviderLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmEditWeeklySchedule" id="frmEditWeeklySchedule" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="id">
                        <label for="day_of_week" class="form-label">Day of Week:</label>
                        <input type="text" class="form-control" id="day_of_week" placeholder="Day Of Week" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="is_closed" class="form-label">Is Closed:</label>
                        <div class="form-group mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_closed" id="is_closed_1" value="0">
                                <label class="form-check-label" for="is_closed_1"><strong>Open</strong></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_closed" id="is_closed_2" value="1">
                                <label class="form-check-label" for="is_closed_2"><strong>Close</strong></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3" id="sted_tm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_last_name" class="form-label">Start Time:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="start_time" id="start_time" placeholder="Start Time">
                                    <button type="button" title="Remove Time" class="btn btn-outline-secondary" onclick="st_tm.clear()">x</button>
                                </div>
                                <div class="text-danger" id="err_start_time"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_time" class="form-label">End Time:</label>
                                <div class="input-group">
                                    <input type="text" name="end_time" id="end_time" class="form-control" placeholder="End Time" aria-label="end_time" aria-describedby="basic-addon2">
                                    <button type="button" title="Remove Time" class="btn btn-outline-secondary" onclick="ed_tm.clear()">x</button>
                                </div>
                                <div class="text-danger" id="err_end_time"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3" id="lnh_tm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lunch_start" class="form-label">Lunch Start:</label>
                                <div class="input-group">
                                    <input type="text" name="lunch_start" id="lunch_start" class="form-control" placeholder="Lunch Start" aria-label="Lunch Start" aria-describedby="basic-addon2">
                                    <button type="button" title="Remove Time" class="btn btn-outline-secondary" onclick="lun_tm.clear()">x</button>
                                </div>
                                <div class="text-danger" id="err_lunch_start"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Lunch End:</label>
                                <div class="input-group">
                                    <input type="text" name="lunch_end" id="lunch_end" class="form-control" placeholder="Lunch End" aria-label="Lunch Start" aria-describedby="basic-addon2">
                                    <button type="button" title="Remove Time" class="btn btn-outline-secondary" onclick="lun_ed.clear()">x</button>
                                </div>
                                
                                <div class="text-danger" id="err_lunch_end"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="btnWekSchSubmit"
                        class="btn btn-primary">Save</button>
                    <button class="btn btn-primary d-none" id="loaderWekSch" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Edit Weekly Schedule --}}
@endsection