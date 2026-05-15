@extends('admin.layouts.app')

@section('content')
<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Block Time Or Range</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Block Time or Range</li>
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
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Add Block Time or Range" data-bs-toggle="modal" data-bs-target="#addBlockTmRngPop" data-bs-whatever="addBlockTmRngPop" role="button"><i class="bi bi-plus-circle"></i> Add </a>
                            </div>
                        {{-- <div class="d-flex justify-content-end">
                            
                        </div> --}}
                    </div>
                    {{-- /.card-header --}}
                    <div class="card-body">
                    <table class="table table-striped table-sm" id="blocktimerange-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Day of Week</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Is Full Day</th>
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

{{-- Add block time Range By Form in POPUP --}}
<div class="modal fade" id="addBlockTmRngPop" tabindex="-1" aria-labelledby="varyingaddBlockTmRngPopLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingaddBlockTmRngPopLabel">Add Block Time</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmAddBlockTimeRange" id="frmAddBlockTimeRange" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="block_type" class="form-label">Block Type</label>
                                <select name="type" id="block_type" class="form-select">
                                    <option value="">Select</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="date">Date</option>
                                    <option value="range">Range</option>
                                </select>
                                <div class="text-danger" id="err_blktyp"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="day_of_week" class="form-label">Day of Week</label>
                                <select name="day_of_week" id="day_of_week" class="form-select">
                                    <option value="">Select Day</option>
                                    @for($i = 1; $i <= 7; $i++)
                                    <option value="{{$i}}">{{getDayName($i)}}</option>
                                    @endfor
                                </select>
                                <div class="text-danger" id="err_dow"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 d-none" id="isfullday_div">
                        <div class="col-md-12">
                            <label for="is_full_day" class="form-label">Is Fullday Block:</label>
                            <div class="form-group mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_full_day" id="is_fullday_1" value="1">
                                    <label class="form-check-label" for="is_fullday_1"><strong>Yes</strong></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_full_day" id="is_fullday_2" value="0">
                                    <label class="form-check-label" for="is_fullday_2"><strong>No</strong></label>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 d-none" id="dat_div">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="st_date" class="form-label">Start Date:<small id="stdspn"></small></label>
                                <input type="text" name="start_date" id="start_date" class="form-control" placeholder="Start Date" aria-label="Start Date" aria-describedby="basic-addon2" readonly>
                                <div class="text-danger" id="err_stdt"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ed_date" class="form-label">End Date:</label>
                                <input type="text" name="end_date" id="end_date" class="form-control" placeholder="End Date" aria-label="End Date" aria-describedby="basic-addon2" readonly>
                                <div class="text-danger" id="err_ed_date"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3 d-none" id="tim_div">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Start Time</label>
                                <div class="input-group">
                                    <input type="text" name="start_time" id="st_time" class="form-control" placeholder="24-Hour format accepted">
                                    <button type="button" title="Remove Time" class="btn btn-outline-secondary" onclick="st_tm_pckr.clear()">x</button>
                                </div>
                                <div class="text-danger" id="err_sttm"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">End Time</label>
                                <div class="input-group">
                                    <input type="text" name="end_time" id="ed_time" class="form-control" aria-describedby="basic-addon2" placeholder="24-Hour format accepted">
                                    <button type="button" title="Remove Time" class="btn btn-outline-secondary" onclick="ed_tm_pckr.clear()">x</button>
                                </div>
                                <div class="text-danger" id="err_ed_tm"></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-danger" id="server_err"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="btnBlockTmSubmit"
                        class="btn btn-primary">Save</button>
                    <button class="btn btn-primary d-none" id="loaderABlkTm" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Add block time Range By Form in POPUP END --}}
@endsection