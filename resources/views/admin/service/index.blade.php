@extends('admin.layouts.app')

@section('content')
<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Services</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Services</li>
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
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Add Service" data-bs-toggle="modal" data-bs-target="#addServicePop" data-bs-whatever="addServicePop"
                        role="button"><i class="bi bi-plus-circle"></i> Add</a>
                        </div>
                    </div>
                    {{-- /.card-header --}}
                    <div class="card-body">
                    <table class="table table-striped table-sm" id="services-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Duration</th>
                            <th>Price($)</th>
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
{{-- Add Department PopUp --}}
<div class="modal fade" id="addServicePop" tabindex="-1" aria-labelledby="varyingServiceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingServiceLabel">Add Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmAddService" id="frmAddService" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                    
                    <div class="mb-3" id="s0">
                        <small class="text-danger">(Don't select any <strong>Parent Service</strong> and just specify <strong>Name</strong> to create a New Parent Service)</small><br>
                        <label for="parent_service" class="form-label">Parent Service</label>
                        <select class="form-select" name="parent_service" id="parent_service">
                            <option value="">Select Parent</option>
                            @forelse($parent_services as $val)
                            <option value="{{$val->id}}">{{ $val->service_name }}</option>
                            @empty
                            <option value=""><span class="text-danger">No Parent</span></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="mb-3" id="s1">
                        <label for="service_name" class="form-label">Service Name</label>
                        <input type="text" class="form-control" name="service_name" id="service_name" placeholder="Service Name"
                            maxlength="40">
                        <div class="text-danger" id="err_service_name"></div>
                    </div>
                    <div class="mb-3 d-none" id="duration_div">
                        <label for="duration" class="form-label">Duration:</label>
                        <div class="input-group" id="s2">
                            <input type="text" name="duration" id="duration" class="form-control" placeholder="Duration" aria-label="Duration" aria-describedby="basic-addon2" disabled>
                            <span class="input-group-text" id="basic-addon2">Min</span>
                            
                        </div>
                        <div class="text-danger" id="err_duration"></div>
                    </div>
                    
                    <div class="mb-3 d-none" id="price_div">
                        <label for="price" class="form-label">Price:</label>
                        <div class="input-group" id="s3">
                            <span class="input-group-text" id="basic-addon2">$</span>
                            <input type="text" name="price" id="price" class="form-control" placeholder="Price" aria-label="Price" aria-describedby="basic-addon2" disabled>
                            
                        </div>
                        <div class="text-danger" id="err_price"></div>
                    </div>
                    <div class="mb-3 d-none" id="tax_div">
                        <label class="form-label">Taxable</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_taxable" id="is_taxable_1" value="1" checked="true">
                            <label class="form-check-label" for="is_taxable_1"> Yes </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_taxable" id="is_taxable_2" value="0">
                            <label class="form-check-label" for="is_taxable_2"> No </label>
                        </div>
                    </div>
                    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="addServiceAction('frmAddService')" id="btnLog"
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
{{-- Add Service PopUp End --}}

{{-- Edit Service Popup --}}
<div class="modal fade" id="editServicePop" tabindex="-1" aria-labelledby="varyingEditServiceLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingEditServiceLabel">Edit Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmEditService" id="frmEditService" action="javascript:void(0);" method="POST">
                <input type="hidden" name="id" value="">
                <div class="modal-body">
                    <div class="mb-3" id="es0">
                        <label for="parent_service" class="form-label">Parent Service</label>
                        <select class="form-select" name="parent_service" id="e_parent_service">
                            <option value="">Select Parent</option>
                            @forelse($parent_services as $val)
                            <option value="{{$val->id}}">{{ $val->service_name }}</option>
                            @empty
                            <option value=""><span class="text-danger">No Parent</span></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="mb-3" id="es1">
                        <label for="name" class="form-label">Service Name</label>
                        <input type="text" class="form-control" name="service_name" id="e_service_name" placeholder="Service Name"
                            maxlength="40">
                        <div class="text-danger" id="error_e_service_name"></div>
                    </div>
                    <div class="mb-3" id="dura_div">
                        <label for="duration" class="form-label">Duration:</label>
                        <div class="input-group" id="es2">
                            <input type="text" name="duration" id="e_duration" class="form-control" placeholder="Duration" aria-label="Duration" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">Min</span>
                        </div>
                        <div class="text-danger" id="error_e_duration"></div>
                    </div>
                    
                    <div class="mb-3" id="e_price_div">
                        <label for="Price" class="form-label">Price:</label>
                        <div class="input-group" id="es3">
                            <span class="input-group-text" id="basic-addon2">$</span>
                            <input type="text" name="price" id="e_price" class="form-control" placeholder="Price" aria-label="Price" aria-describedby="basic-addon2">
                        </div>
                        <div class="text-danger" id="error_e_price"></div>
                    </div>
                    <div class="mb-3" id="e_tax_div">
                        <label for="is_taxable" class="form-label">Taxable</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_taxable" id="e_is_taxable_1" value="1">
                            <label class="form-check-label" for="is_taxable_1"> Yes </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_taxable" id="e_is_taxable_2" value="0">
                            <label class="form-check-label" for="is_taxable_2"> No </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="editServiceAction('frmEditService')" id="btnLog"
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
{{-- Edit Service Popup End --}}
@endsection