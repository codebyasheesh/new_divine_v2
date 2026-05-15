@extends('admin.layouts.app')

@section('content')
<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Service Provider</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Service Providers</li>
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
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Add Service Provider" data-bs-toggle="modal" data-bs-target="#addServiceProviderPop" data-bs-whatever="addServiceProviderPop"
                        role="button"><i class="bi bi-plus-circle"></i> Add</a>
                        </div>
                    </div>
                    {{-- /.card-header --}}
                    <div class="card-body">
                    <table class="table table-striped table-sm" id="service-provider-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Lic/Speciality</th>
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
{{-- Add Service Provider PopUp --}}
<div class="modal fade" id="addServiceProviderPop" tabindex="-1" aria-labelledby="varyingServiceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingServiceLabel">Add Service Provider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmAddServiceProvider" id="frmAddServiceProvider" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name"
                            maxlength="20">
                        <div class="text-danger" id="err_fn"></div>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name"
                            maxlength="20">
                        <div class="text-danger" id="err_ln"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="email" aria-label="email" aria-describedby="basic-addon2">
                        <div class="text-danger" id="err_email"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile:</label>
                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="mobile" aria-label="mobile" aria-describedby="basic-addon2">
                        <div class="text-danger" id="err_mobile"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <select name="title" id="title" class="form-select">
                            <option value="">Select Title</option>
                            <option value="Registered Therapist">Registered Therapist</option>
                            <option value="Wellness Practitioner">Wellness Practitioner</option>
                            <option value="Aesthetician">Aesthetician</option>
                        </select>
                        <div class="text-danger" id="err_title"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">License/ Speciality</label>
                        <input type="text" name="license" id="license" class="form-control" placeholder="license" aria-label="license" aria-describedby="basic-addon2">
                        <div class="text-danger" id="err_license"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="btnServiceProviderSubmit"
                        class="btn btn-primary">Save</button>
                    <button class="btn btn-primary d-none" id="loaderSPSub" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Add Service PopUp End --}}

{{-- Edit Service Popup --}}
<div class="modal fade" id="editServiceProviderPop" tabindex="-1" aria-labelledby="varyingEditServiceProviderLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingEditServiceProviderLabel">Edit Service Provider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmEditServiceProvider" id="frmEditServiceProvider" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="id">
                        <label for="e_first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="e_first_name" id="e_first_name" placeholder="First Name"
                            maxlength="20">
                        <div class="text-danger" id="err_e_fn"></div>
                    </div>
                    <div class="mb-3">
                        <label for="e_last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="e_last_name" id="e_last_name" placeholder="Last Name"
                            maxlength="20">
                        <div class="text-danger" id="err_e_ln"></div>
                    </div>
                    <div class="mb-3">
                        <label for="e_email" class="form-label">Email:</label>
                        <input type="email" name="e_email" id="e_email" class="form-control" placeholder="email" aria-label="email" aria-describedby="basic-addon2">
                        <div class="text-danger" id="err_e_email"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="e_mobile" class="form-label">Mobile:</label>
                        <input type="text" name="e_mobile" id="e_mobile" class="form-control" placeholder="mobile" aria-label="mobile" aria-describedby="basic-addon2">
                        <div class="text-danger" id="err_e_mobile"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <select name="e_title" id="e_title" class="form-select">
                            <option value="">Select Title</option>
                            <option value="Registered Therapist">Registered Therapist</option>
                            <option value="Wellness Practitioner">Wellness Practitioner</option>
                            <option value="Aesthetician">Aesthetician</option>
                        </select>
                        <div class="text-danger" id="err_e_title"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">License/ Speciality</label>
                        <input type="text" name="e_license" id="e_license" class="form-control" placeholder="license" aria-label="license" aria-describedby="basic-addon2">
                        <div class="text-danger" id="err_e_license"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="btnEServiceProviderSubmit"
                        class="btn btn-primary">Save</button>
                    <button class="btn btn-primary d-none" id="loaderESPSub" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Edit Service Popup End --}}
@endsection