@extends('admin.layouts.app')

@section('content')
<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Date Override</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Date Override</li>
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
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Add Date Orverride" data-bs-toggle="modal" data-bs-target="#addDateOverridePop" data-bs-whatever="addDateOverridePop" role="button"><i class="bi bi-plus-circle"></i>Add</a>
                            </div>
                        {{-- <div class="d-flex justify-content-end">
                            
                        </div> --}}
                    </div>
                    {{-- /.card-header --}}
                    <div class="card-body">
                    <table class="table table-striped table-sm" id="date-override-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Full Day Close</th>
                            <th>Custom Start Time</th>
                            <th>Custom End Time</th>
                            <th>Created At</th>
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
<div class="modal fade" id="addDateOverridePop" tabindex="-1" aria-labelledby="varyingaddBlockTmRngPopLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingaddBlockTmRngPopLabel">Add Override Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmDateOverride" id="frmDateOverride" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="block_type" class="form-label">Date</label>
                                <input type="text" name="date" id="date" class="form-control" placeholder="Enter Date">
                                <div class="text-danger" id="err_date"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="is_full_day" class="form-label">Is Fullday Block:</label>
                            <div class="form-group mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_closed" id="is_closed_1" value="1">
                                    <label class="form-check-label" for="is_closed_1"><strong>Yes</strong></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_closed" id="is_closed_2" value="0">
                                    <label class="form-check-label" for="is_closed_2"><strong>No</strong></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3 d-none" id="dorr_tim_div">
                        <div class="col-md-6">
                            <div class="form-group">
                                
                                <label class="form-label">Custom Start Time</label>
                                <div class="input-group">
                                    <input type="text" name="cus_start_time" id="cus_st_time" class="form-control" step="1800">
                                    <button type="button" title="Remove Time" class="btn btn-outline-secondary" onclick="cus_tm_pckr.clear()">x</button>
                                </div>
                                
                                <div class="text-danger" id="err_cussttm"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Custom End Time</label>
                                <div class="input-group">
                                    <input type="text" name="cus_end_time" id="cus_ed_time" class="form-control" aria-describedby="basic-addon2" step="1800">
                                    <button type="button" title="Remove Time" class="btn btn-outline-secondary" onclick="cus_etm_pckr.clear()">x</button>
                                </div>
                                
                                <div class="text-danger" id="err_cusedtm"></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-danger" id="server_err"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="btnDateOverrideSubmit"
                        class="btn btn-primary">Save</button>
                    <button class="btn btn-primary d-none" id="loaderDtOvRi" type="button" disabled>
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