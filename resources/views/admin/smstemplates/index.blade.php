@extends('admin.layouts.app')

@section('content')
<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Sms Templates</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sms Templates</li>
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
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Add SMS Template" data-bs-toggle="modal" data-bs-target="#addSMSTemplatePop" data-bs-whatever="addSMSTemplatePop" role="button"><i class="bi bi-plus-circle"></i> Add</a>
                            </div>
                        </div>
                        {{-- <div class="d-flex justify-content-start">
                            
                        </div> --}}
                    </div>
                    {{-- /.card-header --}}
                    <div class="card-body">
                    <table class="table table-striped table-sm" id="smstemplates-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Template</th>
                            <th>key</th>
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

{{-- Add SMS Template --}}
<div class="modal fade" id="addSMSTemplatePop" tabindex="-1" aria-labelledby="varyingSmsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingSmsLabel">Add Sms Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmAddSMS" id="frmAddSMS" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="template_name" class="form-label">Template Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="template_name" id="template_name" placeholder="Template Name" maxlength="40">
                            </div>
                            <div class="text-danger ms-5 err-template_name"></div>
                        </div>
                        <div class="col-6">
                            <label for="sms_key" class="form-label">Template Key:</label>
                            <div class="input-group">
                                <input type="text" name="sms_key" id="sms_key" class="form-control" placeholder="Sms Key" aria-label="Email" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 err-sms_key"></div>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <label for="body" class="form-label">Body:</label>
                            <textarea name="body" id="body" class="form-control" placeholder="SMS Content" maxlength="300"></textarea>
                            <div id="sms_count" class="text-muted">Characters: 0</div>
                            <div class="text-danger ms-5 err-body"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="btnSmsSubmit"
                        class="btn btn-primary">Save</button>
                    <button class="btn btn-primary d-none" id="a_loader" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Add SMS Template End --}}

{{-- Edit SMS Template POPUP --}}
<div class="modal fade" id="editSMSTemplatePop" tabindex="-1" aria-labelledby="varyingESmsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingESmsLabel">Edit Sms Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmEditSMS" id="frmEditSMS" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="template_name" class="form-label">Template Name</label>
                            <div class="input-group">
                                <input type="hidden" name="id" value="">
                                <input type="text" class="form-control" name="e_template_name" id="e_template_name" placeholder="Template Name" maxlength="40">
                            </div>
                            <div class="text-danger ms-5 error-template_name"></div>
                        </div>
                        <div class="col-6">
                            <label for="sms_key" class="form-label">Template Key:</label>
                            <div class="input-group">
                                <input type="text" name="e_sms_key" id="e_sms_key" class="form-control" placeholder="Sms Key" aria-label="Email" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-sms_key"></div>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <label for="body" class="form-label">Body:</label>
                            <textarea name="e_body" id="e_body" class="form-control" placeholder="SMS Content" maxlength="280"></textarea>
                            <div id="esms_count" class="text-muted">Characters: 0</div>
                            <div class="text-danger ms-5 error-body"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="btnESmsSubmit"
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
{{-- Edit SMS Template POPUP END --}}
@endsection