@extends('admin.layouts.app')

@section('content')
<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Profile</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Clients</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
        </div>
    </div>
    {{--end::Row--}}
    </div>
    {{--end::Container--}}
</div>

<div class="app-content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
            <div class="text-center">
                @if(empty($logged_user->gender))
                <img class="profile-user-img img-fluid img-circle" src="{{asset('admin_assets/assets/img/boxed-bg.jpg')}}" alt="User profile picture">
                @else
                    @if($logged_user->gender == 'Male')
                    <img class="profile-user-img img-fluid img-circle" src="{{asset('admin_assets/assets/img/avatar-1.webp')}}" alt="User profile picture">
                    @elseif($logged_user->gender == 'Female')
                    <img class="profile-user-img img-fluid img-circle" src="{{asset('admin_assets/assets/img/avatar-2.webp')}}" alt="User profile picture">
                    @else
                    <img class="profile-user-img img-fluid img-circle" src="{{asset('admin_assets/assets/img/boxed-bg.jpg')}}" alt="User profile picture">
                    @endif
                @endif
                
            </div>

            <h3 class="profile-username text-center">{{ $logged_user->first_name.' '.$logged_user->last_name }}</h3>

            {{-- <p class="text-muted text-center">Software Engineer</p> --}}
            @if($all_members[0]['family_id'] > 0) 
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">Family Members
                        <span class="badge text-bg-primary rounded-pill">{{@count($all_members)}}</span>
                    </li>
                </ul>
            @endif
            

            {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- About Me Box -->
        <div class="card card-primary">
            <div class="card-header">
            <h3 class="card-title">About Me</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

            @php
            $sendMedicalForm = "sendMedicalForm('".$logged_user->customer_id."')";
            @endphp
            <a href="javascript:void(0);" onclick="{{ $sendMedicalForm }}"><i class="bi bi-send-arrow-up"></i> Send Medical Form</a>
            <div class="d-none" id="sp_smf_{{ $logged_user->customer_id }}" style="width:0.8rem; height:0.8rem;"></div>          

            <hr>
            <a href="{{route('admin.download.medicaldetail', $logged_user->customer_id)}}"><i class="bi bi-download"></i> Download Medical Detail</a>
            <hr>
            <strong><i class="fas fa-book mr-1"></i> Email</strong>

            <p class="text-muted">
                {{$logged_user->email}}
            </p>

            <hr>

            <strong><i class="fas fa-map-marker-alt mr-1"></i> Mobile</strong>

            <p class="text-muted">{{($logged_user->mobile) ? substr($logged_user->mobile, 0, 3).'-'.substr($logged_user->mobile, 3, 3).'-'.substr($logged_user->mobile, 6, 4) : ''}}</p>

            <hr>

            <strong><i class="fas fa-map-marker-alt mr-1"></i> Gender</strong>

            <p class="text-muted">{{$logged_user->gender ?? 'N/A'}}</p>

            <hr>

            <strong><i class="fas fa-pencil-alt mr-1"></i> Date of Birth</strong>
            <p class="text-muted">{{(!empty($logged_user->dob))?get_formatted_date($logged_user->dob, 'M d, Y'):'MDY'}}</p>
            <hr>
            <strong><i class="fas fa-pencil-alt mr-1"></i> Address:</strong>
            <p>{{$logged_user->address ?? 'No Address'}}<br>{{$logged_user->city}} {{$logged_user->state}} {{($logged_user->postal_code) ? ', '.substr($logged_user->postal_code, 0, 3).' '. substr($logged_user->postal_code, 3, 3) : ''}}</p>
            <hr>

            <strong><i class="fas fa-pencil-alt mr-1"></i> Soap Note:</strong>
            @php
            // $soapnote_path = public_path('admin_assets/assets/document/'.$logged_user->soap_note_link);
            $soapnote_path = asset('admin_assets/assets/document/'.$logged_user->soap_note_link);
            @endphp
            <p>
            {!! ($logged_user->soap_note_link != '')? '<a href="'.$soapnote_path.'" target="_blank">Soap Note</a>' : 'N/A' !!}</p>
            <hr>

            <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

            <p class="text-muted">{{$logged_user->remark}}</p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
            <ul class="nav nav-pills" id="myTab">
                <li class="nav-item">
                    <a class="nav-link active" id="activity-tab" href="#activity" data-toggle="tab">Medical Detail</a>
                </li>
                <li class="nav-item"><a class="nav-link" id="timeline-tab" href="#timeline" data-toggle="tab">Booking History</a></li>
                <li class="nav-item">
                    <a class="nav-link" id="settings-tab" href="#settings" data-toggle="tab">Family</a></li>
            </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
            <div class="tab-content">
                <div class="active tab-pane" id="activity">
                <!-- Post -->
                    @if(!empty($logged_user_medical))
                    <div class="post">
                        <div class="user-block">
                            <div class="row">
                                <label class="col-form-label col-lg-3">
                                    <strong>First Name: </strong>
                                </label>
                                <div class="col-lg-3 mt-2 text-start">{{$logged_user_medical->first_name}}</div>

                                <label class="col-form-label col-lg-3">
                                    <strong>Last Name: </strong>
                                </label>
                                <div class="col-lg-3 mt-2">{{$logged_user_medical->last_name}}</div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-lg-3">
                                    <strong>DOB: </strong>
                                </label>
                                <div class="col-lg-3 mt-2 text-start">{{($logged_user_medical->dob != NULL && $logged_user_medical->dob != '1970-01-01') ? get_formatted_date($logged_user_medical->dob, 'M d, Y') : 'MDY'}}</div>

                                <label class="col-form-label col-lg-3">
                                    <strong>Email: </strong>
                                </label>
                                <div class="col-lg-3 mt-2">{{$logged_user_medical->email}}</div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-lg-3">
                                    <strong>Address: </strong>
                                </label>
                                <div class="col-lg-3 mt-2 text-start">{{$logged_user_medical->address}}</div>

                                <label class="col-form-label col-lg-3">
                                    <strong>City: </strong>
                                </label>
                                <div class="col-lg-3 mt-2">{{$logged_user_medical->city}}</div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-lg-3">
                                    <strong>Postal Code: </strong>
                                </label>
                                <div class="col-lg-3 mt-2 text-start">{{substr($logged_user_medical->postal_code, 0, 3).' '.substr($logged_user_medical->postal_code, 3, 3)}}</div>

                                <label class="col-form-label col-lg-3">
                                    <strong>Primary Phone: </strong>
                                </label>
                                <div class="col-lg-3 mt-2">{{substr($logged_user_medical->primary_phone, 0, 3).'-'.substr($logged_user_medical->primary_phone, 3, 3).'-'.substr($logged_user_medical->primary_phone, 6, 4)}}</div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-lg-3">
                                    <strong>Other Phone: </strong>
                                </label>
                                <div class="col-lg-3 mt-2 text-start">{{$logged_user_medical->other_phone ?? 'Not Available'}}</div>

                                <label class="col-form-label col-lg-3">
                                    <strong>Occupation: </strong>
                                </label>
                                <div class="col-lg-3 mt-2">{{$logged_user_medical->occupation ?? 'Not Available'}}</div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-lg-3">
                                    <strong>Emergency Contact Name: </strong>
                                </label>
                                <div class="col-lg-3 mt-2 text-start">{{$logged_user_medical->emergency_contact_name ?? 'Not Available'}}</div>

                                <label class="col-form-label col-lg-3">
                                    <strong>Emergency Contact Phone: </strong>
                                </label>
                                <div class="col-lg-3 mt-2">{{$logged_user_medical->emergency_contact_phone ? substr($logged_user_medical->emergency_contact_phone, 0, 3).'-'.substr($logged_user_medical->emergency_contact_phone, 3, 3).'-'.substr($logged_user_medical->emergency_contact_phone, 6, 4) : 'Not Available'}}</div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-lg-3">
                                    <strong>Source of Referral: </strong>
                                </label>
                                <div class="col-lg-3 mt-2 text-start">{{$logged_user_medical->source_of_referral ?? 'Not Available'}}</div>

                                <label class="col-form-label col-lg-3">
                                    <strong>Do You Have Extended Health Care Benefits: </strong>
                                </label>
                                <div class="col-lg-3 mt-2">{{$logged_user_medical->extended_health_care_benefit}}</div>
                            </div>
                            <hr />
                            <div class="row">
                                <label class="col-form-label col-lg-5">
                                    <strong>Benefits Insurance Company Name:</strong>
                                </label>
                                <div class="col-lg-7 mt-2 text-start">{{$logged_user_medical->benefits_insurance_company_name}}</div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-lg-5">
                                    <strong>Are You the Primary Member:</strong>
                                </label>
                                <div class="col-lg-7 mt-2 text-start">{{$logged_user_medical->primary_member}}</div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-lg-3">
                                    <strong>Primary Member:</strong>
                                </label>
                                <div class="col-lg-3 mt-2 text-start">{{$logged_user_medical->primary_member_name ?? 'Not Applicable'}}</div>
                                
                                <label class="col-form-label col-lg-3">
                                    <strong>Primary Member DOB:</strong>
                                </label>
                                <div class="col-lg-3 mt-2 text-start">{{($logged_user_medical->primary_member_dob != NULL && $logged_user_medical->primary_member_dob != '1970-01-01')?get_formatted_date($logged_user_medical->primary_member_dob, 'M d, Y'): 'MDY'}}</div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-lg-3">
                                    <strong>CONTRACT/POLICY/PLAN #: (include all zeros):</strong>
                                </label>
                                <div class="col-lg-3 mt-2 text-start">{{$logged_user_medical->contract_policy_plan_no ?? 'Not Applicable'}}</div>
                                
                                <label class="col-form-label col-lg-3">
                                    <strong>MEMBER/ CERTIFICATE #: (include all zeros):</strong>
                                </label>
                                <div class="col-lg-3 mt-2 text-start">{{$logged_user_medical->member_certificate_no ?? 'Not Applicable'}}</div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-lg-6"><strong>Do you authorize us to Direct Bill your Insurance for your treatment?</strong></label>
                                <div class="col-lg-6 mt-2">
                                    {{$logged_user_medical->authorize_us_to_direct_bill}}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-lg-6"><strong>Do you have Secondary Insurance Coverage?</strong></label>
                                <div class="col-lg-6 mt-2">
                                    {{$logged_user_medical->second_insurance_coverage}}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-lg-6"><strong>Second Insurance Company Name:</strong></label>
                                <div class="col-lg-6 mt-2">
                                    {{$logged_user_medical->second_insu_comp_name}}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-lg-6"><strong>Primary Member:</strong></label>
                                <div class="col-lg-6 mt-2">
                                    {{$logged_user_medical->primary_member_name_2}}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-lg-6"><strong>Primary Member DOB:</strong></label>
                                <div class="col-lg-6 mt-2">
                                    {{$logged_user_medical->primary_member_dob_2}}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-lg-6"><strong>CONTRACT/POLICY/PLAN #: (include all zeros):</strong></label>
                                <div class="col-lg-6 mt-2">
                                    {{$logged_user_medical->contract_policy_plan_no_2}}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-form-label col-lg-6"><strong>MEMBER/ CERTIFICATE #: (include all zeros):</strong></label>
                                <div class="col-lg-6 mt-2">
                                    {{$logged_user_medical->member_certificate_no_2}}
                                </div>
                            </div>
                        </div>
                        <!-- /.user-block -->

                    </div>
                
                    <div class="post">
                        <div class="user-block">
                            <h4>Patient Health History</h4>
                        </div>
                        
                        <div class="row mt-5 mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Were you recently involved in a Motor Vehicle Accident OR injured at work?</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->v_accident_or_injured}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>If yes, please provide all pertinent information such as date of incident, type of injury, Insurance company and claim number, Adjuster's name:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->all_pertinent_infomation}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Any other current injuries or illnesses, and their treatment in progress:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->other_current_injuries}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Primary reason for requesting Massage Therapy:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->primary_complaint}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Did a health care practitioner refer you for Massage?:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->refer_by_practitioner}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Primary Physician / Referring Health Care Provider Name:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->health_cre_profess_name}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Health Care/ Family Doctor Address/Phone etc:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->family_doc_addrs}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Have you had Massage Therapy before?</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->received_massage_before}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Are you currently receiving other treatments from any other health care professional?</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->received_treatment_from_another}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>If yes, please provide type of treatment (chiropractic, physiotherapy, etc.)</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->if_yes_treatment_type}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Current Medications:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->current_medications}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Do you have any Allergies:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->any_allergies}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Please name all the things you are allergic to:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->allergy_lst}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Please list all surgeries and approximate dates:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->list_all_surgeries}}
                            </div>                        
                        </div>
                        <hr />
                        <div class="row mb-3">
                            <h5>Please indicate conditions you are experiencing or have experienced:</h5>
                            <label class="col-form-label col-lg-6" ><strong>Cardiovascular:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->cardiovascular}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Gastrointestinal:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->gastrointestinal}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Muscle / Joint:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->muscle_joint}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Respiratory:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->respiratory}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Skin:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->skin}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Head / Neck:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->head_neck}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Other Conditions:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->other_medical_conditions}}
                            </div>                        
                        </div>
                        <hr />
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Is there a family history of any of the conditions listed above?:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->is_family_history}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Do you have any internal pins, wires, artificial joints or special equipment?:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->internal_pin_wire_joint}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>If yes, where?:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->joint_or_pin_text}}
                            </div>                        
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-3" ><strong>General Health:</strong></label>
                            <div class="col-lg-3 mt-2">
                                {{$logged_user_medical->good_health}}
                            </div>
                            <label class="col-form-label col-lg-3" ><strong>Female (Pregnant, Due):</strong></label>
                            <div class="col-lg-3 mt-2">
                                {{$logged_user_medical->pregnant ?? 'N/A'}} {{$logged_user_medical->pregnant_due_date ?? ', N/A'}}
                            </div> 
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Have you given birth within last three months?:</strong></label>
                            <div class="col-lg-6 mt-2">
                                {{$logged_user_medical->pregnancy_three_month ?? ' N/A'}}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-6" ><strong>Signature:</strong></label>
                            <div class="col-lg-6 mt-2">
                                <img src="{{asset('storage/'.$logged_user_medical->signature_path)}}" alt="">
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="post">
                        <div class="user-block">
                            <div class="row">
                                <div class="col-lg-12">
                                    No Detail Found
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                {{-- /.post --}}
                </div>
                {{-- /.tab-pane --}}
                <div class="tab-pane" id="timeline">
                {{-- The timeline --}}
                    <div class="timeline timeline-inverse">
                        {{-- timeline time label --}}
                        @forelse($bok_his as $val) 
                        @switch($val->booking_status)
                            @case ('completed')
                                @php
                                $dat_class = 'bg-success text-white';
                                @endphp
                                @break
                            @case ('confirmed')
                                @php
                                $dat_class = 'bg-primary text-white';
                                @endphp
                                @break
                            @case ('pending')
                                @php
                                $dat_class = 'bg-warning text-black';
                                @endphp
                                @break
                            @case ('canceled')
                                @php
                                $dat_class = 'bg-danger text-white';
                                @endphp
                                @break

                            @case ('declined')
                                @php
                                $dat_class = 'bg-secondary text-white';
                                @endphp
                                @break
                        @endswitch

                        <div class="time-label">
                            <span class="{{$dat_class}}">
                                {{get_formatted_date($val->booking_date, 'M d, Y')}}
                            </span>
                        </div>
                        <div>
                            <i class="fas fa-envelope bg-primary"></i>

                            <div class="timeline-item">
                                {{-- <span class="time"><i class="far fa-clock"></i> 12:05</span> --}}

                                <h3 class="timeline-header">Booking For:</h3>

                                <div class="timeline-body">
                                <strong>Services: </strong> {{ implode(', ', $val->service_names) }} <br />
                                <strong>Booking Status: </strong> {{ucfirst($val->booking_status)}}
                                <br />
                                <strong>Total Amount:</strong> {{'$ '.$val->total_amount}}
                                </div>
                                {{-- <div class="timeline-footer">
                                <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </div> --}}
                            </div>
                        </div>
                        @empty
                        <div class="">No Booking Records</div>
                        @endforelse
                        {{-- END timeline item --}}
                    </div>
                </div>
                {{-- /.tab-pane --}}

                <div class="tab-pane" id="settings">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-3 d-flex justify-content-start">
                                            Members
                                        </div>
                                        <div class="col-9 d-flex justify-content-end">
                                            <a href="javascript:void(0);" data-dependent="no" class="btn btn-sm btn-primary openModalBtn" data-bs-toggletip="tooltip" data-bs-title="Add Family Member" data-bs-toggle="modal" data-bs-target="#addCustomerPop" data-bs-whatever="addCustomerPop" role="button"><i class="bi bi-plus-circle"></i> Create Family Member</a>

                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary ms-2 openModalBtn" data-dependent="yes" data-bs-toggletip="tooltip" data-bs-title="Add Dependent" data-bs-toggle="modal" data-bs-target="#addCustomerPop" data-bs-whatever="addCustomerPop" role="button"><i class="bi bi-plus-circle"></i> Add Dependent</a>

                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary ms-2" data-bs-toggletip="tooltip" data-bs-title="Add Existing in Family" data-bs-toggle="modal" data-bs-target="#addExistingClientPop" data-bs-whatever="addExistingClientPop" role="button"><i class="bi bi-plus-circle"></i> Add Existing in Family</a>
                                        </div>
                                    </div>
                                </div>
                                {{-- /.card-header --}}
                                <div class="card-body">
                                <table class="table table-striped table-sm" id="family_memb">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>DOB</th>
                                        <th>Remark</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($all_members as $member)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td><a href="{{ route('admin.userprofile', $member['id']) }}">{{$member['first_name'].' '.$member['last_name']}}</a></td>
                                            <td>{{$member['email']}}</td>
                                            <td>{{($member['mobile']) ? substr($member['mobile'], 0, 3).'-'.substr($member['mobile'], 3, 3).'-'.substr($member['mobile'], 6, 4) : ''}}</td>
                                            <td>{{($member['dob'] != NULL && $member['dob'] != '1970-01-01')?get_formatted_date($member['dob'], 'M d, Y') : 'MDY'}}</td>
                                            <td>{{$member['remark'] ?? 'No Remark'}}</td>
                                            <td>
                                                @if($member['deleted_at'] == '')
                                                <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Edit Family Member Detail" data-bs-toggle="modal" data-bs-target="#editCustomerPop" data-bs-whatever="editCustomerPop" role="button" onclick="viewMemberDetail('{{$member['id']}}');"><i class="bi bi-pencil-square"></i> Edit</a>
                                                @else
                                                <span>Account Deleted</span>
                                                @endif
                                            </td>
                                        </tr>
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
                </div>
                {{-- /.tab-pane --}}
            </div>
            {{-- /.tab-content --}}
            </div>{{-- /.card-body --}}
        </div>
        {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
    </div>{{-- /.container-fluid --}}
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
                                    <select name="byear" id="byear" class="form-select" onchange="setDaysCount(document.getElementById('bmonth').value, 'bday', 'byear');">
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
                                <input type="text" name="state" id="state" class="form-control" placeholder="Province" maxlength="30">
                            </div>
                            <div class="text-danger ms-5 error-e_state"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="postal_code" class="form-label">Postal Code:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-mailbox"></i></span>
                                <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Postal Code" maxlength="7" aria-label="Postal Code" aria-describedby="basic-addon2">
                            </div>
                            <div class="text-danger ms-5 error-e_postal_code"></div>
                        </div>
                        
                        <div class="col-6 mb-3">
                            <label for="remark" class="form-label">Remark:</label>
                            <textarea name="remark" id="remark" class="form-control" placeholder="Remark" maxlength="80"></textarea>
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
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <input type="hidden" name="dependent" id="e_dependent" value="">
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
                        <div class="col-12 mb-3">
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
                                <input type="text" name="state" id="e_state" class="form-control" placeholder="Enter Province" maxlength="30">
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
                            <textarea name="remark" id="e_remark" class="form-control" placeholder="Remark"></textarea>
                            
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

@endsection