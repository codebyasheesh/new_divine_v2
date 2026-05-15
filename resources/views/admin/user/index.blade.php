@extends('admin.layouts.app')

@section('content')
<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Clients</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Clients</li>
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
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Add New Client" data-bs-toggle="modal" data-bs-target="#addUserPop" data-bs-whatever="addUserPop"
                        role="button"><i class="bi bi-plus-circle"></i> Add New Client</a>
                        </div>
                    </div>
                    {{-- /.card-header --}}
                    <div class="card-body">
                    <table class="table table-striped table-sm" id="users-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>DOB</th>
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
<div class="modal fade" id="addUserPop" tabindex="-1" aria-labelledby="varyingUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingUserLabel">Add Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmAddUser" id="frmAddUser" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <input type="hidden" name="is_primary" value="1">
                            <label for="name" class="form-label">First Name</label>
                            <div class="input-group" id="u1">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" maxlength="40">
                            </div>
                            <div class="text-danger ms-5 error-first_name"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="name" class="form-label">Last Name</label>
                            <div class="input-group" id="u1">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" maxlength="40">
                            </div>
                            <div class="text-danger ms-5 error-last_name"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <div class="input-group" id="u2">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-envelope-at"></i></span>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-email"></div>
                        </div>
                        
                        <div class="col-6 mb-3">
                            <label for="mobile" class="form-label">Mobile:</label>
                            <div class="input-group" id="u3">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-phone"></i></span>
                                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="e.g: xxx-xxx-xxxx or like xxx xxx xxxx" maxlength="12" aria-label="Mobile" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-mobile"></div>
                        </div>
                        <div class="col-8 mb-3">
                            <label for="dob" class="form-label">Date of Birth:</label>
                            <div class="row">
                                <div class="col-sm-4">
                                    @php
                                        $currentYear = date('Y');
                                        $startYear = $currentYear - 80; // 100 years ago
                                    @endphp
                                    <select name="byear" id="byear" class="form-select" onchange="setDaysCount(document.getElementById('bmonth').value, 'bday', 'byear');">
                                        <option value="">Year</option>
                                        @foreach(range($currentYear, $startYear) as $year)
                                            <option value="{{ $year }}">
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
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
                                <div class="col-sm-4">
                                    <select name="bday" id="bday" class="form-select">
                                        <option value="">Date</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="text-danger ms-5 error-dob"></div>
                        </div>
                        <div class="col-4 mb-3">
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
                                <textarea type="text" name="address" id="address" class="form-control" placeholder="Address" maxlength="80"></textarea>
                            </div>
                            <div class="text-danger ms-5 error-address"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="city" class="form-label">City:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" name="city" id="city" class="form-control" placeholder="City" maxlength="80" aria-label="City" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-city"></div>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="state" class="form-label">Province:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" name="state" id="state" class="form-control" placeholder="Province" maxlength="30" aria-label="state" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-state"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="postal_code" class="form-label">Postal Code:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-mailbox"></i></span>
                                <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Postal Code" maxlength="10" aria-label="Postal Code" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-postal_code"></div>
                        </div>
                        
                        <div class="col-6 mb-3">
                            <label for="remark" class="form-label">Remark:</label>
                            <textarea name="remark" id="remark" class="form-control" placeholder="Remark"></textarea>
                            
                            <div class="text-danger ms-5 error-remark"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="addUserAction('frmAddUser')" id="btnLog"
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
<div class="modal fade" id="editUserPop" tabindex="-1" aria-labelledby="varyingEditUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingEditUserLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmEditUser" id="frmEditUser" action="javascript:void(0);" method="POST">
                <input type="hidden" name="id" value="">
                <input type="hidden" name="dependent" value="">
                <input type="hidden" name="is_primary" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <input type="hidden" name="e_family_id" value="">
                            <label for="first_name" class="form-label">First Name</label>
                            <div class="input-group" id="eu1">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="first_name" id="e_first_name" placeholder="First Name" maxlength="40">
                            </div>
                            <div class="text-danger ms-5 e-error-first_name"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <div class="input-group" id="eu1">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="last_name" id="e_last_name" placeholder="Last Name" maxlength="30">
                            </div>
                            <div class="text-danger ms-5 e-error-last_name"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <div class="input-group" id="eu2">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-envelope-at"></i></span>
                                <input type="email" name="email" id="e_email" class="form-control" placeholder="Email"  aria-label="Email">
                            </div>
                            <div class="text-danger ms-5 e-error-email"></div>
                        </div>
                        
                        <div class="col-6 mb-3">
                            <label for="mobile" class="form-label">Mobile:</label>
                            <div class="input-group" id="es3">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-phone"></i></span>
                                <input type="text" name="mobile" id="e_mobile" class="form-control" placeholder="Mobile" maxlength="12" aria-label="Mobile">
                            </div>
                            <div class="text-danger ms-5 e-error-mobile"></div>
                        </div>
                        <div class="col-9 mb-3">
                            <label for="dob" class="form-label">Date of Birth:</label>
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
                            {{-- <div class="input-group" id="u4">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-calendar-check"></i></span>
                                <input type="text" name="dob" id="e_dob" class="form-control" placeholder="Date of Birth" readonly aria-label="dob" aria-describedby="basic-addon2">
                            </div> --}}
                            <div class="text-danger ms-5 e-error-dob"></div>
                        </div>
                        <div class="col-3 mb-3">
                            <label for="gender" class="form-label">Gender:</label>
                            <select name="gender" id="e_gender" class="form-select">
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <div class="text-danger ms-5 e-error-gender"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Address:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-geo-alt"></i></span>
                                <textarea name="address" id="e_address" class="form-control" placeholder="Address" maxlength="80" aria-label="Address" aria-describedby="basic-addon2"></textarea>
                            </div>
                            <div class="text-danger ms-5 e-error-address"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="city" class="form-label">City:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" name="city" id="e_city" class="form-control" placeholder="City" maxlength="80">
                            </div>
                            <div class="text-danger ms-5 e-error-city"></div>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="state" class="form-label">Province:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" name="state" id="e_state" class="form-control" placeholder="Enter Province" maxlength="30">
                            </div>
                            <div class="text-danger ms-5 e-error-state"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="postal_code" class="form-label">Postal Code:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-mailbox"></i></span>
                                <input type="text" name="postal_code" id="e_postal_code" class="form-control" placeholder="Postal Code" maxlength="7" aria-label="Postal Code" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 e-error-postal_code"></div>
                        </div>
                        
                        <div class="col-6 mb-3">
                            <label for="remark" class="form-label">Remark:</label>
                            <textarea name="remark" id="e_remark" class="form-control" placeholder="Remark"></textarea>
                            
                            <div class="text-danger ms-5 error-e_remark"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="editUserAction('frmEditUser')" id="btnLog"
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
{{-- Edit User Popup End --}}
@endsection