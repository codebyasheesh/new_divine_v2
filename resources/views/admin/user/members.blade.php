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
                <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Clients</a></li>
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
                        {{-- <h3 class="card-title">Services</h3> --}}
                        <div class="row">
                            <div class="col-lg-4 d-flex justify-content-start">
                                <a href="{{route('admin.users')}}" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Back to Register Users List" role="button"><i class="bi bi-arrow-left-circle"></i> Back</a>
                            </div>
                            <div class="col-lg-8 d-flex justify-content-end">
                                <a href="javascript:void(0);" data-dependent="no" class="btn btn-sm btn-primary openModalBtn" data-bs-toggletip="tooltip" data-bs-title="Add Family Member" data-bs-toggle="modal" data-bs-target="#addCustomerPop" data-bs-whatever="addCustomerPop" role="button"><i class="bi bi-plus-circle"></i> Create Family Member</a>

                                <a href="javascript:void(0);" class="btn btn-sm btn-primary ms-2 openModalBtn" data-dependent="yes" data-bs-toggletip="tooltip" data-bs-title="Add Dependent" data-bs-toggle="modal" data-bs-target="#addCustomerPop" data-bs-whatever="addCustomerPop" role="button"><i class="bi bi-plus-circle"></i> Add Dependent</a>

                                <a href="javascript:void(0);" class="btn btn-sm btn-primary ms-2" data-bs-toggletip="tooltip" data-bs-title="Add Existing in Family" data-bs-toggle="modal" data-bs-target="#addExistingClientPop" data-bs-whatever="addExistingClientPop" role="button"><i class="bi bi-plus-circle"></i> Add Existing in Family</a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary ms-2" data-bs-toggletip="tooltip" data-bs-title="Show Existing Members" data-bs-toggle="modal" data-bs-target="#showExistingMembersPop" data-bs-whatever="showExistingMembersPop" role="button"><i class="bi bi-arrow-repeat"></i> Change Primary</a>
                                
                            </div>
                        </div>
                        {{-- <div class="d-flex justify-content-end">
                            
                        </div> --}}
                    </div>
                    {{-- /.card-header --}}
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
                            @php
                                $city = '';
                                $state = '';
                                $postal_code = '';
                                
                                if($val['city']) {
                                    $city = '<br>'.$val['city'];
                                }
                                if(!empty($val['state'])) {
                                    $coma = ($city)?', ':'';
                                    $state = $coma.$val['state'];
                                }
                                if(!empty($val['postal_code'])) {
                                    $coma = ($state)?', ':'';
                                    $postal_code = $coma.$val['postal_code'];
                                }
                                
                                $complete_addr = $city.$state.$postal_code;
                                $mobile = substr($val['mobile'], 0, 3).'-'.substr($val['mobile'], 3, 3).'-'.substr($val['mobile'], 6, 4);
                            @endphp
                            @if($loop->first)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><a href="{{route('admin.userprofile', $val['id'])}}">{{$val['first_name'].' '.$val['last_name'] ?? ''}}</a> @if($val['is_primary'] == 1)<span class="badge text-bg-success">P</span>@endif</td>
                                <td>{{$val['email']}}</td>
                                <td>{{$mobile}}</td>
                                <td><p>{!!$val['address'].$complete_addr!!}</p></td>
                                <td>&nbsp;</td>
                            </tr>
                            @else
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><a href="{{route('admin.userprofile', $val['id'])}}">{{$val['first_name'].' '.$val['last_name'] ?? ''}}</a></td>
                                <td>{{$val['email']}}</td>
                                <td>{{$mobile}}</td>
                                <td><p>{!!$val['address'].$complete_addr!!}</p></td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Edit Family Member Detail" data-bs-toggle="modal" data-bs-target="#editCustomerPop" data-bs-whatever="editCustomerPop"
                        role="button" onclick="viewMemberDetail('{{$val['id']}}');"><i class="bi bi-pencil-square"></i> Edit</a>
                                    <a href="javascript:void(0);" onclick="removeMember('{{$val['id']}}')" class="btn btn-sm btn-danger" data-bs-toggletip="tooltip" data-bs-title="Remove Member from this Family"><i class="bi bi-trash"></i> Remove</a>
                                </td>
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
<div class="modal fade" id="addCustomerPop" tabindex="-1" aria-labelledby="varyingCustomerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingCustomerLabel">Add Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmAddCustomer" id="frmAddCustomer" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <input type="hidden" name="dependent" value="">
                            <input type="hidden" name="is_primary" value="0">
                            <input type="hidden" name="family_id" value="{{$all_members[0]['family_id']}}">
                            <input type="hidden" name="parent_id" value="{{$all_members[0]['id']}}">
                            
                            <label for="first_name" class="form-label">First Name</label>
                            <div class="input-group" id="u1">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" maxlength="40">
                            </div>
                            <div class="text-danger ms-5 error-first_name"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <div class="input-group" id="u1">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" maxlength="30">
                            </div>
                            <div class="text-danger ms-5 error-last_name"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-envelope-at"></i></span>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-email"></div>
                        </div>
                        
                        <div class="col-6 mb-3">
                            <label for="mobile" class="form-label">Mobile:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-phone"></i></span>
                                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile" maxlength="12" aria-label="Mobile" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-mobile"></div>
                        </div>
                        <div class="col-9 mb-3">
                            <label class="form-label">Date Of Birth:</label>
                            <div class="row">
                                <div class="col-4">
                                    @php
                                        $currentYear = date('Y');
                                        $startYear = $currentYear - 80; // 100 years ago
                                    @endphp
                                    <select name="byear" id="byear" class="form-select">
                                        <option value="">Year</option>
                                        @foreach(range($currentYear, $startYear) as $year)
                                            <option value="{{ $year }}">
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    @php
                                    $mnth = ['01'=>'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];
                                    @endphp
                                    <select name="bmonth" id="bmonth" class="form-select" onchange="setDaysCount(this.value, 'bday', 'byear');">
                                        <option value="">Month</option>
                                        @foreach(range(1, 12) as $month)
                                        @php
                                            $formattedMonth = sprintf('%02d', $month);
                                        @endphp
                                            <option value="{{ $month }}">
                                                {{ $mnth[$formattedMonth] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="bday" id="bday" class="form-select">
                                        <option value="">Date</option>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="text-danger ms-5 error-dob"></div>
                        </div>
                        <div class="col-3 mb-3">
                            <label for="gender" class="form-label">Gender:</label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <div class="text-danger ms-5 error-gender"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Address:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-geo-alt"></i></span>
                                <textarea name="address" id="address" class="form-control" placeholder="Address" maxlength="80" aria-label="Address" aria-describedby="basic-addon2"></textarea>
                            </div>
                            <div class="text-danger ms-5 error-address"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="city" class="form-label">City:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" name="city" id="city" class="form-control" placeholder="City" maxlength="80" aria-label="City" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-e_city"></div>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="state" class="form-label">Province:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" name="state" id="state" class="form-control" placeholder="Enter Province" maxlength="30" aria-label="state" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-e_state"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="postal_code" class="form-label">Postal Code:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-mailbox"></i></span>
                                <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Postal Code" maxlength="7" aria-label="Postal Code" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-postal_code"></div>
                        </div>
                        
                        <div class="col-6 mb-3">
                            <label for="remark" class="form-label">Remark:</label>
                            <textarea name="remark" id="remark" class="form-control" placeholder="Remark" maxlength="80" aria-label="Address" aria-describedby="basic-addon2"></textarea>
                            <div class="text-danger ms-5 error-remark"></div>
                        </div>
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
</div>
{{-- Add Customer PopUp End --}}

{{-- Edit Customer Popup --}}
<div class="modal fade" id="editCustomerPop" tabindex="-1" aria-labelledby="varyingEditCustomerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingEditCustomerLabel">Edit Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmEditCustomer" id="frmEditCustomer" action="javascript:void(0);" method="POST">
                <input type="hidden" name="id" value="">
                <input type="hidden" name="dependent" id="e_dependent" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <input type="hidden" name="id" value="">
                            <label for="first_name" class="form-label">First Name</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="first_name" id="e_first_name" placeholder="Customer Name" maxlength="40">
                            </div>
                            <div class="text-danger ms-5 error-e_first_name"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="last_name" id="e_last_name" placeholder="Last Name" maxlength="30">
                            </div>
                            <div class="text-danger ms-5 error-e_last_name"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-envelope-at"></i></span>
                                <input type="email" name="email" id="e_email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-e_email"></div>
                        </div>
                        
                        <div class="col-6 mb-3">
                            <label for="mobile" class="form-label">Mobile:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-phone"></i></span>
                                <input type="text" name="mobile" id="e_mobile" class="form-control" placeholder="Mobile" maxlength="12" aria-label="Mobile" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-e_mobile"></div>
                        </div>
                        <div class="col-9 mb-3">
                            <label class="form-label">Date of Birth:</label>
                            <div class="row">
                                <div class="col-4">
                                    @php
                                        $currentYear = date('Y');
                                        $startYear = $currentYear - 80; // 100 years ago
                                    @endphp
                                    <select name="byear" id="e_byear" class="form-select" onchange="setDaysCount(document.getElementById('e_bmonth').value, 'e_bday', 'e_byear');">
                                        <option value="">Year</option>
                                        @foreach(range($currentYear, $startYear) as $year)
                                            <option value="{{ $year }}">
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    @php
                                    $mnth = ['01'=>'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];
                                    @endphp
                                    <select name="bmonth" id="e_bmonth" class="form-select" onchange="setDaysCount(this.value, 'e_bday', 'e_byear');">
                                        <option value="">Month</option>
                                        @foreach(range(1, 12) as $month)
                                        @php
                                            $formattedMonth = sprintf('%02d', $month);
                                        @endphp
                                            <option value="{{ $formattedMonth }}">
                                                {{ $mnth[$formattedMonth] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="bday" id="e_bday" class="form-select">
                                        <option value="">Date</option>
                                        @foreach(range(1, 31) as $day)
                                            @php
                                                // Use sprintf to format the number with a leading zero
                                                $formattedDay = sprintf('%02d', $day); 
                                            @endphp
                                            <option value="{{ $formattedDay }}">
                                                {{ $formattedDay }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="text-danger ms-5 error-e_dob"></div>
                        </div>
                        <div class="col-3 mb-3">
                            <label for="gender" class="form-label">Gender:</label>
                            <select name="gender" id="e_gender" class="form-select">
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <div class="text-danger ms-5 error-e_gender"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="address" class="form-label">Address:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-geo-alt"></i></span>
                                <textarea name="address" id="e_address" class="form-control" placeholder="Address" maxlength="80" aria-label="Address" aria-describedby="basic-addon2"></textarea>
                            </div>
                            <div class="text-danger ms-5 error-e_address"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="city" class="form-label">City:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" name="city" id="e_city" class="form-control" placeholder="City" maxlength="80" aria-label="City" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-e_city"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="state" class="form-label">Province:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" name="state" id="e_state" class="form-control" placeholder="Province" maxlength="30">
                            </div>
                            <div class="text-danger ms-5 error-e_state"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="postal_code" class="form-label">Postal Code:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-mailbox"></i></span>
                                <input type="text" name="postal_code" id="e_postal_code" class="form-control" placeholder="Postal Code" maxlength="7" aria-label="Postal Code" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-e_postal_code"></div>
                        </div>
                        
                        <div class="col-6 mb-3">
                            <label for="remark" class="form-label">Remark:</label>
                            <textarea name="remark" id="e_remark" class="form-control" placeholder="Remark" maxlength="80" aria-label="Address" aria-describedby="basic-addon2"></textarea>
                            <div class="text-danger ms-5 error-e_remark"></div>
                        </div>
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

{{-- Add Existing Person as a Family Member --}}
<div class="modal fade" id="addExistingClientPop" tabindex="-1" aria-labelledby="varyingCustomerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingCustomerLabel">Add Individual as Family Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmAddIndividualAsFamily" id="frmAddIndividualAsFamily" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <input type="hidden" name="family_id" value="{{$all_members[0]['family_id']}}">
                            <input type="hidden" name="parent_id" value="{{$all_members[0]['id']}}">
                            <label class="form-label">Exist Individual Client</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="indv_person_search" name="exist_person_name" value="" placeholder="Enter name or mobile" aria-describedby="customer_idHelp"
                                />
                            </div>
                            <div id="indv_person_suggestions" class="list-group"></div>
                            <input type="hidden" name="member_id">
                            <div class="text-danger ms-5 error-member_id"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="exist_email" class="form-label">Email:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-envelope-at"></i></span>
                                <input type="email" name="exist_email" id="exist_email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon2" readonly>
                            </div>
                            <div class="text-danger ms-5 error-email"></div>
                        </div>
                        
                        <div class="col-6 mb-3">
                            <label for="exist_mobile" class="form-label">Mobile:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-phone"></i></span>
                                <input type="text" name="exist_mobile" id="exist_mobile" class="form-control" placeholder="Mobile" maxlength="12" aria-label="Mobile" aria-describedby="basic-addon2" readonly>
                            </div>
                            <div class="text-danger ms-5 error-mobile"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="addIndividualPersonAction('frmAddIndividualAsFamily')" id="btnLog"
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
{{-- End Add Existing Person as a Family Member --}}

{{-- List all Family Members for Change primary member --}}
<div class="modal fade" id="showExistingMembersPop" tabindex="-1" aria-labelledby="varyingCustomerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingCustomerLabel">Change Primary Member of Family </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmChangeParentInFamily" id="frmChangeParentInFamily" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div>
                                <label class="form-label">Family Members:</label>
                            </div>
                            
                            @foreach($all_members as $key => $val)
                                @php
                                $checked = '';
                                $email = $val->email;
                                $mobile = $val->mobile;
                                @endphp
                                @if($val->email == '') 
                                @php
                                    $email = 'N/A';
                                @endphp
                                @endif
                                @if($val->mobile == '')
                                @php
                                $mobile = 'N/A';
                                @endphp
                                @endif
                                @if($val->is_primary == 1)
                                @php
                                $checked = 'checked';
                                @endphp
                                @endif
                                
                                @if($checked)
                                <input type="hidden" name="main_parent" value="{{ $val->id }}">
                                @endif
                                @if(!empty($val->email) && !empty($val->mobile) )
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="make_parent" id="make_parent{{$key}}" value="{{$val->id}}" {{ $checked }}>
                                    <label class="form-check-label" for="make_parent{{$key}}">{{ $val->first_name.' '.$val->last_name.' ('.$email .'), ( '.$mobile.' )' }}</label>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="changeMainParent('frmChangeParentInFamily')" id="btnLog"
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
{{-- End List all Family Members for Change primary member --}}
@endsection