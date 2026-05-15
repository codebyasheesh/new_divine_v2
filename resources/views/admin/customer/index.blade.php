@extends('admin.layouts.app')

@section('content')
<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Family Members</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Family Members</li>
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
                            <div class="col-lg-6 d-flex justify-content-start">
                                <a href="{{route('admin.users')}}" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Back to Register Users List" role="button"><i class="bi bi-arrow-left-circle"></i> Back</a>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end">
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Add Family Member" data-bs-toggle="modal" data-bs-target="#addCustomerPop" data-bs-whatever="addCustomerPop" role="button"><i class="bi bi-plus-circle"></i> Add Family Member</a>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="card-body">
                    <table class="table table-striped table-sm" id="customer-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($all_members as $val)
                            @if($loop->first)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$val['name'].' (Primary)'}}</td>
                                <td>{{$val['email']}}</td>
                                <td>{{$val['mobile']}}</td>
                                <td>{{$val['address']}}</td>
                                <td>&nbsp;</td>
                            </tr>
                            @else
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$val['name']}}</td>
                                <td>{{$val['email']}}</td>
                                <td>{{$val['mobile']}}</td>
                                <td>{{$val['address']}}</td>
                                <td><a href="javascript:void(0);" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Edit Family Member Detail" data-bs-toggle="modal" data-bs-target="#editCustomerPop" data-bs-whatever="editCustomerPop"
                        role="button" onclick="viewMemberDetail('{{$val['id']}}', 'child');"><i class="bi bi-pencil-square"></i> Edit</a></td>
                            </tr>
                            @endif 
                            
                            @empty
                            <tr>
                                <td colspan="6">No Record Found</td>
                            </tr>
                            @endforelse
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
{{-- Add Customer PopUp --}}
{{-- <div class="modal fade" id="addCustomerPop" tabindex="-1" aria-labelledby="varyingCustomerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingCustomerLabel">Add Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmAddCustomer" id="frmAddCustomer" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="parent_id" value="{{$all_members[0]['id']}}">
                        <label for="name" class="form-label">Customer Name</label>
                        <div class="input-group" id="u1">
                            <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="Customer Name" maxlength="40">
                        </div>
                        <div class="text-danger ms-5 error-customer_name"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon2"><i class="bi bi-envelope-at"></i></span>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon2">
                        </div>
                        <div class="text-danger ms-5 error-email"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="Price" class="form-label">Mobile:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon2"><i class="bi bi-phone"></i></span>
                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile" maxlength="10" aria-label="Mobile" aria-describedby="basic-addon2">
                        </div>
                        <div class="text-danger ms-5 error-mobile"></div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon2"><i class="bi bi-geo-alt"></i></span>
                            <textarea name="address" id="address" class="form-control" placeholder="Address" maxlength="80" aria-label="Address" aria-describedby="basic-addon2"></textarea>
                        </div>
                        <div class="text-danger ms-5 error-address"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="addCustomerAction('frmAddCustomer')" id="btnLog"
                        class="btn btn-primary">Save</button>
                    <button class="btn btn-primary d-none" id="loader" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
{{-- Add Customer PopUp End --}}

{{-- Edit Customer Popup --}}
<div class="modal fade" id="editCustomerPop" tabindex="-1" aria-labelledby="varyingEditCustomerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingEditCustomerLabel">Edit Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmEditCustomer" id="frmEditCustomer" action="javascript:void(0);" method="POST">
                <input type="hidden" name="id" value="">
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="id" value="">
                        <label for="name" class="form-label">Customer Name</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" name="customer_name" id="e_customer_name" placeholder="Customer Name" maxlength="40">
                        </div>
                        <div class="text-danger ms-5 error-e_customer_name"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon2"><i class="bi bi-envelope-at"></i></span>
                            <input type="email" name="email" id="e_email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon2">
                        </div>
                        <div class="text-danger ms-5 error-e_email"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="Price" class="form-label">Mobile:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon2"><i class="bi bi-phone"></i></span>
                            <input type="text" name="mobile" id="e_mobile" class="form-control" placeholder="Mobile" maxlength="10" aria-label="Mobile" aria-describedby="basic-addon2">
                        </div>
                        <div class="text-danger ms-5 error-e_mobile"></div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon2"><i class="bi bi-geo-alt"></i></span>
                            <textarea name="address" id="e_address" class="form-control" placeholder="Address" maxlength="80" aria-label="Address" aria-describedby="basic-addon2"></textarea>
                        </div>
                        <div class="text-danger ms-5 error-e_address"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="updateMemberAction('frmEditCustomer')" id="btnLog"
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
{{-- Edit Customer Popup End --}}
@endsection