@extends('frontend.layouts.app')

@section('content')
<div class="section-padding">
   <div class="container text-center">
      <div class="iq-title-box">
         <span class="iq-subtitle text-uppercase">Patient Intake Form</span>
         
         <p class="iq-title-desc text-body mt-3 mb-0">
            Please reach out to us for any questions - we are always happy to assist
         </p>
      </div>      
      <div class="row">
         <div class="col-lg-2 d-lg-block d-none"></div>
         <div class="col-lg-8">
            {{-- @if ($errors->any())
                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; margin-bottom: 15px;">
                    <h3>Validation Errors:</h3>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}
            @php
            $showPart3 = 'd-none';
            $showPart4 = 'd-none';
            @endphp
            @if($mdl_data)
                @if(empty($mdl_data->last_name) || empty($mdl_data->dob) || empty($mdl_data->gender) || empty($mdl_data->email) || empty($mdl_data->address) || empty($mdl_data->city) || empty($mdl_data->province) || empty($mdl_data->postal_code) || empty($mdl_data->primary_phone) || empty($mdl_data->emergency_contact_name) || empty($mdl_data->emergency_contact_phone) || empty($mdl_data->extended_health_care_benefit) )
                    @php
                    $showPart1 = '';
                    @endphp
                    @else
                    @php
                    $showPart1 = 'd-none';
                    @endphp
                @endif

                @if($mdl_data->extended_health_care_benefit == 'No')
                    @php
                    $showPart2 = 'd-none'; // second parth will not show
                    $showPart3 = '';
                    @endphp
                @elseif($mdl_data->extended_health_care_benefit == 'Yes' && empty($mdl_data->benefits_insurance_company_name) && empty($mdl_data->health_cre_profess_name))
                    @php
                        $showPart2 = '';
                        $showPart3 = 'd-none';
                    @endphp
                    
                @endif

                @if(!empty($mdl_data->benefits_insurance_company_name) &&  !empty($mdl_data->health_cre_profess_name))
                    @php
                    $showPart2 = 'd-none';
                    $showPart3 = 'd-none';
                    $showPart4 = '';
                    @endphp
                @elseif(!empty($mdl_data->benefits_insurance_company_name) &&  empty($mdl_data->health_cre_profess_name))
                    @php
                    $showPart2 = 'd-none';
                    $showPart3 = '';
                    $showPart4 = 'd-none';
                    @endphp
                @endif
            @else
                @php
                $showPart1 = '';
                $showPart2 = 'd-none';
                $showPart3 = 'd-none';
                $showPart4 = 'd-none';
                @endphp
            @endif
            <div class="row {{$showPart1}}" id="part_1" >
                <div class="col-lg-12">
                    <form id="frmMedicalForm" action="{{ route('save_medical_form') }}" method="post">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="customer_id" value="{{ $customer_id }}">
                            <div class="col-lg-4">

                                <div class="custom-form-field mb-5">
                                    <label for="first_name" class="d-flex justify-content-start">First Name<span class="text-danger"> *</span></label>
                                    <input type="text" name="first_name" id="first_name" placeholder="Your Name" value="{{ old('first_name', $customer_detail->first_name ?? '') }}" class="form-control">
                                    <div class="text-danger text-start" id="f_error"></div>
                                    @error('first_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                @php
                                $get_last_nm = str_word_count($customer_detail->first_name);
                                $middle_nm = '';
                                @endphp
                                @if($get_last_nm > 1)
                                @php
                                $middle_nm = ucwords(explode(' ', $customer_detail->first_name)[1]);
                                @endphp
                                @endif
                                
                                <div class="custom-form-field mb-5">
                                    <label for="middle_name" class="d-flex justify-content-start">Middle Name</label>
                                    <input type="text" name="middle_name" id="middle_name" placeholder="Your Middle Name" value="{{ old('middle_name', $middle_nm ?? '') }}" class="form-control">
                                    @error('middle_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="custom-form-field mb-5">
                                    <label for="last_name" class="d-flex justify-content-start">Last Name<span class="text-danger"> *</span></label>
                                    <input type="text" name="last_name" id="last_name" placeholder="Last Name" value="{{ old('last_name', $customer_detail->last_name ?? '') }}" class="form-control">
                                    <div class="text-danger text-start" id="l_error"></div>
                                    @error('last_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                @php
                                // pr($customer_detail);
                                @endphp
                                <div class="custom-form-field mb-5">
                                    <label for="dob" class="d-flex justify-content-start">Date of Birth<span class="text-danger"> *</span></label>
                                    <div class="row">
                                        <div class="col-4">
                                            @php 
                                            $dob = ($customer_detail->dob != null && $customer_detail->dob != '1970-01-01')?get_formatted_date($customer_detail->dob, 'Y-m-d'):'';
                                            $days = '';
                                            /*if(!empty($dob)) {
                                                $days = cal_days_in_month(CAL_GREGORIAN, explode('-', $dob)[1], explode('-', $dob)[0]);
                                            }*/
                                            
                                            @endphp
                                            @php
                                                $currentYear = date('Y');
                                                $startYear = $currentYear - 80; // 100 years ago
                                            @endphp
                                            <select name="dob_y" id="dob_y" class="form-select" onchange="setDaysCount(document.getElementById('dob_m').value, 'dob_d', 'dob_y');">
                                                <option value="">Year</option>
                                                @foreach(range($currentYear, $startYear) as $year)
                                                    <option value="{{ $year }}" {{ old('dob_y', explode('-', $dob ?? '')[0] ?? '') == $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            @php
                                            $mnth = ['01'=>'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];
                                            @endphp
                                            <select name="dob_m" id="dob_m" class="form-select" onchange="setDaysCount(this.value, 'dob_d', 'dob_y');">
                                                <option value="">Month</option>
                                                @php
                                                    $dbMonth = !empty($dob) ? explode('-', $dob)[1] : '';
                                                @endphp
                                                @foreach(range(1, 12) as $month)
                                                @php
                                                    $formattedMonth = sprintf('%02d', $month);
                                                @endphp
                                                    <option value="{{ $formattedMonth }}" {{ old('dob_m', $dbMonth) == $formattedMonth ? 'selected' : '' }}>
                                                        {{ $mnth[$formattedMonth] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <select name="dob_d" id="dob_d" class="form-select">
                                                <option value="">Date</option>
                                                @php
                                                    $dbDay = !empty($dob) ? explode('-', $dob)[2] : '';
                                                    $selectedMonth = old('dob_m', $dbMonth ?? '');
                                                    $selectedYear  = old('dob_y', !empty($dob) ? explode('-', $dob)[0] : date('Y'));
                                                    $days = ($selectedMonth && $selectedYear) ? cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear) : 31;
                                                @endphp
                                                @if($dob)
                                                @foreach(range(1, $days) as $day)
                                                    <option value="{{$day}}" {{ old('dob_d', $dbDay) == $day ? 'selected' : '' }}>{{$day}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="text-danger text-start" id="dob_error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="custom-form-field mb-5">
                                    <label for="gender" class="d-flex justify-content-start">Gender<span class="text-danger"> *</span></label>
                                    <select name="gender" id="gender" class="form-select">
                                        <option value="">Select</option>
                                        <option value="Male" {{ ($customer_detail->gender == 'Male')?'selected' : '' }}>Male</option>
                                        <option value="Female" {{ ($customer_detail->gender == 'Female')?'selected' : '' }}>Female</option>
                                        <option value="Other" {{ ($customer_detail->gender == 'Other')?'selected' : '' }}>Other</option>
                                    </select>
                                    <div class="text-danger text-start" id="gender_error"></div>
                                    @error('gender')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="custom-form-field mb-5">
                                    <label for="pronoun" class="d-flex justify-content-start">Preferred Pronoun</label>
                                    <input type="text" name="pronoun" id="pronoun" class="form-control" value="{{ old('pronoun') }}" />
                                    @error('pronoun')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-form-field mb-5">
                                    <label for="email" class="d-flex justify-content-start">Email<span class="text-danger"> *</span></label>
                                    <input type="email" name="email" id="email" placeholder="Your Email" value="{{ old('email', $customer_detail->email ?? '') }}" class="form-control">
                                    <div class="text-danger text-start" id="email_error"></div>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-form-field mb-5">
                                    <label for="address" class="d-flex justify-content-start">Address<span class="text-danger"> *</span></label>
                                    <input type="text" name="address" id="address" placeholder="Your Address" value="{{ old('address', $customer_detail->address ?? '') }}" class="form-control">
                                    <div class="text-danger text-start" id="address_error"></div>
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-form-field mb-5">
                                    <label for="city" class="d-flex justify-content-start">City<span class="text-danger"> *</span></label>
                                    <input type="text" name="city" id="city" placeholder="Your City" value="{{ old('city', $customer_detail->city ?? '') }}" class="form-control">
                                    <div class="text-danger text-start" id="city_error"></div>
                                    @error('city')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-form-field mb-5">
                                    <label for="province" class="d-flex justify-content-start">Province<span class="text-danger"> *</span></label>
                                    <select name="province" id="province" class="form-select">
                                    <option value="">Select Province</option>
                                    <option value="AB" {{ old('dob_d') == 'AB' ? 'selected' : '' }}>Alberta</option>
                                    <option value="BC" {{ old('dob_d') == 'BC' ? 'selected' : '' }}>British Columbia</option>
                                    <option value="MB" {{ old('dob_d') == 'MB' ? 'selected' : '' }}>Manitoba</option>
                                    <option value="NB" {{ old('dob_d') == 'NB' ? 'selected' : '' }}>New Brunswick</option>
                                    <option value="NL" {{ old('dob_d') == 'NL' ? 'selected' : '' }}>Newfoundland and Labrador</option>
                                    <option value="NS" {{ old('dob_d') == 'NS' ? 'selected' : '' }}>Nova Scotia</option>
                                    <option value="ON" selected>Ontario</option>
                                    <option value="PE" {{ old('dob_d') == 'PE' ? 'selected' : '' }}>Prince Edward Island</option>
                                    <option value="QC" {{ old('dob_d') == 'QC' ? 'selected' : '' }}>Quebec</option>
                                    <option value="SK" {{ old('dob_d') == 'SK' ? 'selected' : '' }}>Saskatchewan</option>
                                    <option value="NT" {{ old('dob_d') == 'NT' ? 'selected' : '' }}>Northwest Territories</option>
                                    <option value="NU" {{ old('dob_d') == 'NU' ? 'selected' : '' }}>Nunavut</option>
                                    <option value="YT" {{ old('dob_d') == 'YT' ? 'selected' : '' }}>Yukon</option>
                                    </select>
                                    <div class="text-danger text-start" id="province_error"></div>
                                    @error('province')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-form-field mb-5">
                                    <label for="postal_code" class="d-flex justify-content-start">Postal Code<span class="text-danger"> *</span></label>
                                    <input type="text" name="postal_code" id="postal_code" maxlength="7" value="{{ old('postal_code', $customer_detail->postal_code ?? '') }}" placeholder="Your Postal Code" class="form-control">
                                    <div class="text-danger text-start" id="pincod_error"></div>
                                    @error('postal_code')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-form-field mb-5">
                                    <label for="primary_phone" class="d-flex justify-content-start">Primary Phone<span class="text-danger"> *</span></label>
                                    <input type="text" name="primary_phone" id="primary_phone" placeholder="Your Primary Phone" value="{{ old('primary_phone', $customer_detail->mobile ?? '') }}" class="form-control" maxlength="12">
                                    <div class="text-danger text-start" id="priph_error"></div>
                                    @error('primary_phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-form-field mb-5">
                                    <label for="other_phone" class="d-flex justify-content-start">Other Phone</label>
                                    <input type="text" name="other_phone" id="other_phone" title="Enter a valid 10-digit mobile number" maxlength="12" placeholder="Your Other Phone" value="{{ old('other_phone') }}" class="form-control">
                                    <div class="text-danger text-start" id="other_phone_error"></div>
                                    @error('other_phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-form-field mb-5">
                                    <label for="occupation" class="d-flex justify-content-start">Occupation</label>
                                    <input type="text" name="occupation" id="occupation" placeholder="Your Occupation" value="{{ old('occupation') }}" class="form-control" maxlength="40">
                                    @error('occupation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-form-field mb-5">
                                    <label for="special_accessibility" class="d-flex justify-content-start">Special Accessibility / Mobility Requirements</label>
                                    <select name="special_accessibility" id="special_accessibility" class="form-select">
                                        <option value="">Select</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                    @error('special_accessibility')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-form-field mb-5">
                                    <label for="emergency_contact_name" class="d-flex justify-content-start">Emergency Contact Name<span class="text-danger"> *</span></label>
                                    <input type="text" name="emergency_contact_name" id="emergency_contact_name" placeholder="Your Emergency Contact Name" value="{{ old('emergency_contact_name') }}" maxlength="40" class="form-control">
                                    <div class="text-danger text-start" id="emrcontnm_error"></div>
                                    @error('emergency_contact_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-form-field mb-5">
                                    <label for="emergency_contact_phone" class="d-flex justify-content-start">Emergency Contact Phone<span class="text-danger"> *</span></label>
                                    <input type="text" name="emergency_contact_phone" id="emergency_contact_phone" placeholder="Your Emergency Contact Phone" value="{{ old('emergency_contact_phone') }}" maxlength="12" class="form-control">
                                    <div class="text-danger text-start" id="emer_cont_error"></div>
                                    @error('emergency_contact_phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-form-field mb-5">
                                    <label for="source_of_referral" class="d-flex justify-content-start">Source of Referral</label>
                                    <input type="text" name="source_of_referral" id="source_of_referral" value="{{ old('source_of_referral') }}" placeholder="Your Source of Referral" class="form-control">
                                    @error('source_of_referral')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="extended_health_benefit" class="d-flex justify-content-start">Do You Have Extended Health Care Benefits? <span class="text-danger">*</span></label>
                                <div class="d-flex mt-3">
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="extended_health_care_benefit" id="extended_health_care_benefit1" value="Yes" {{ old('extended_health_care_benefit') == 'Yes' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="extended_health_care_benefit1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="extended_health_care_benefit" id="extended_health_care_benefit2" value="No" {{ old('extended_health_care_benefit') == 'No' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="extended_health_care_benefit2">No</label>
                                    </div>
                                </div>
                                <div class="text-danger text-start" id="exthlthcar_error"></div>
                                @error('extended_health_care_benefit')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            
                            <div class="col-lg-12 text-start mt-5">
                                <div class="iq-btn-container">
                                <button class="iq-button text-capitalize border-0" type="submit" name="submit_form" value="first">
                                    <span class="iq-btn-text-holder position-relative">Click to validate</span>
                                    <span class="iq-btn-icon-holder">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                            <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </button>
                                <p>and continue to next section</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="row {{$showPart2}}" id="part_2">
                <div class="col-lg-12">
                    <form id="frmMedicalForm_2" action="{{ route('save_medical_form') }}" method="post">
                        @csrf
                        <input type="hidden" name="customer_id" value="{{ $customer_id }}">
                        <div class="row mt-4">
                            <div class="iq-title-box">
                                <span class="iq-subtitle text-uppercase">Patient Insurance Details</span>
                                <p class="iq-title-desc text-body mt-3 mb-0"></p>
                            </div>

                            <div class="col-lg-12 mt-3 mb-5" id="exhlthcarbene_1">
                                <div class="custom-form-field">
                                    <label for="health_benefit_company" class="d-flex justify-content-start">Benefits Insurance Company Name<span class="text-danger" id="bicn">{{ (empty($showPart2)? '*' : '') }}</span></label>
                                    <input type="text" name="health_benefit_company" id="health_benefit_company" class="form-control" placeholder="Insurance Company Name" value="{{ old('health_benefit_company') }}" onblur="document.getElementById('hlth_befit_comp_error').innerHTML=''">
                                </div>
                                <div class="text-danger text-start" id="hlth_befit_comp_error"></div>
                                @error('health_benefit_company')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div id="exhlthcarbene_2" class="mb-5">
                                <div class="col-lg-12">
                                    <label for="is_primary_member" class="d-flex justify-content-start">Are You the Primary Member?<span class="text-danger"> *</span></label>
                                    <div class="d-flex mt-3">
                                        <div class="form-check form-check-inline justify-content-start">
                                            <input class="form-check-input" type="radio" name="is_primary_member" id="is_primary_member1" value="Yes" {{ old('is_primary_member') == 'Yes' ? 'checked' : '' }} onchange="document.getElementById('is_pri_mem_error').innerHTML=''">
                                            <label class="form-check-label" for="is_primary_member1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline justify-content-start">
                                            <input class="form-check-input" type="radio" name="is_primary_member" id="is_primary_member2" value="No" {{ old('is_primary_member') == 'No' ? 'checked' : '' }} onchange="document.getElementById('is_pri_mem_error').innerHTML=''">
                                            <label class="form-check-label" for="is_primary_member2">No</label>
                                        </div>
                                    </div>
                                    <div class="text-danger text-start" id="is_pri_mem_error"></div>
                                    @error('is_primary_member')
                                    <div class="text-danger text-start">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-12" id="pm_1" style="{{$isprimary_option ?? 'display: none;'}}">
                                    <div class="custom-form-field mb-5">
                                        <label for="primary_member" class="d-flex justify-content-start">Primary Member<span class="text-danger"> *</span></label>
                                        <input type="text" name="primary_member" id="pmname" class="form-control" placeholder="Enter the Primary Member Name" value="{{ old('primary_member') }}" onblur="document.getElementById('pmname_error').innerHTML=''">
                                        <div class="text-danger text-start" id="pmname_error"></div>
                                        @error('primary_member')
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12" id="pm_2" style="{{$isprimary_option ?? 'display: none;'}}">
                                    <div class="custom-form-field mb-5">
                                        <label class="d-flex justify-content-start">Primary Member Date of Birth<span class="text-danger"> *</span></label>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                @php
                                                    $currentYear = date('Y');
                                                    $startYear = $currentYear - 80; // 100 years ago
                                                @endphp
                                                <select name="pm_dob_y" id="pm_dob_y" class="form-select" onchange="setDaysCount(document.getElementById('pm_dob_m').value, 'pm_dob_d', 'pm_dob_y');">
                                                    <option value="">Year</option>
                                                    @foreach(range($currentYear, $startYear) as $year)
                                                        <option value="{{ $year }}" {{ old('pm_dob_y') == $year ? 'selected' : '' }}>
                                                            {{ $year }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                @php
                                                $mnth = ['01'=>'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];
                                                @endphp
                                                <select name="pm_dob_m" id="pm_dob_m" class="form-select" onchange="setDaysCount(this.value, 'pm_dob_d', 'pm_dob_y');">
                                                    <option value="">Month</option>
                                                    @foreach(range(1, 12) as $month)
                                                    @php
                                                        $formattedMonth = sprintf('%02d', $month);
                                                    @endphp
                                                        <option value="{{ $formattedMonth }}" {{ old('pm_dob_m') == $formattedMonth ? 'selected' : '' }}>
                                                            {{ $mnth[$formattedMonth] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <select name="pm_dob_d" id="pm_dob_d" class="form-select">
                                                    @php
                                                        $selectedMonth = old('pm_dob_m');
                                                        $selectedYear  = old('pm_dob_y');
                                                        $days = ($selectedMonth && $selectedYear)
                                                            ? cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear)
                                                            : '';
                                                    @endphp
                                                    @if($days)
                                                    @for($day = 1; $day <= $days; $day++)
                                                        <option value="{{ $day }}"
                                                            {{ old('pm_dob_d') == $day ? 'selected' : '' }}>
                                                            {{ $day }}
                                                        </option>
                                                    @endfor
                                                    @else
                                                    <option value="">Date</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="text-danger text-start" id="pm_dob_error"></div>
                                        </div>
                                        @error('pm_dob_y')
                                            <div class="text-danger">Invalid Date of Birth</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6" id="exhlthcarbene_3">
                                <div class="custom-form-field mb-5">
                                    <label for="contract_policy_plan_no" class="d-flex justify-content-start">Enter Your Plan Policy Number: <span class="text-danger" id="cpp"></span></label>
                                    <input type="text" name="contract_policy_plan_no" id="contract_policy_plan_no" value="{{ old('contract_policy_plan_no') }}" class="form-control" placeholder="Enter Your Plan Policy number" onblur="document.getElementById('contra_poli_pln_error').innerHTML=''">
                                    <div class="text-danger text-start" id="contra_poli_pln_error"></div>
                                    @error('contract_policy_plan_no')
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6" id="exhlthcarbene_4">
                                <div class="custom-form-field mb-5">
                                    <label for="member_certificate_no" class="d-flex justify-content-start">MEMBER/ CERTIFICATE #: (include all zeros)<span class="text-danger" id="memcer"></span></label>
                                    <input type="text" name="member_certificate_no" id="member_certificate_no" value="{{ old('member_certificate_no') }}" class="form-control" placeholder="Member ID" onblur="document.getElementById('mem_certi_error').innerHTML=''">
                                    <div class="text-danger text-start" id="mem_certi_error"></div>
                                    @error('member_certificate_no')
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6" id="direct_bill_div">
                                <label for="extended_health_benefit" class="d-flex justify-content-start">Do you authorize us to Direct Bill your Insurance for your treatment?<span class="text-danger" id="direct_bill_spn"> *</span></label>
                                <div class="d-flex mt-1">
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="authorize_us_to_direct_bill" id="authorize_us_to_direct_bill1" value="Yes" {{ old('authorize_us_to_direct_bill') == 'Yes' ? 'checked' : '' }} onchange="document.getElementById('auth_us_dir_bil_error').innerHTML=''">
                                        <label class="form-check-label" for="authorize_us_to_direct_bill1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="authorize_us_to_direct_bill" id="authorize_us_to_direct_bill2" value="No" {{ old('authorize_us_to_direct_bill') == 'No' ? 'checked' : '' }} onchange="document.getElementById('auth_us_dir_bil_error').innerHTML=''">
                                        <label class="form-check-label" for="authorize_us_to_direct_bill2">No</label>
                                    </div>
                                </div>
                                <div class="text-danger text-start" id="auth_us_dir_bil_error"></div>
                                @error('authorize_us_to_direct_bill')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6" id="second_insu_div">
                                <label for="extended_health_benefit" class="d-flex justify-content-start">Do you have Secondary Insurance Coverage?<span class="text-danger" id="seconinsu_spn"> *</span></label>
                                <div class="d-flex mt-3">
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="second_insurance_coverage" id="second_insurance_coverage1" value="Yes" {{ old('second_insurance_coverage') == 'Yes' ? 'checked' : '' }} onchange="document.getElementById('secnd_insu_cover_error').innerHTML=''">
                                        <label class="form-check-label" for="second_insurance_coverage1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="second_insurance_coverage" id="second_insurance_coverage2" value="No" {{ old('second_insurance_coverage') == 'No' ? 'checked' : '' }} onchange="document.getElementById('secnd_insu_cover_error').innerHTML=''">
                                        <label class="form-check-label" for="second_insurance_coverage2">No</label>
                                    </div>
                                </div>
                                <div class="text-danger text-start" id="secnd_insu_cover_error"></div>
                                @error('second_insurance_coverage')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            @if(old('second_insurance_coverage') == 'Yes')
                                @php
                                $secInsCovOpt = '';
                                $sec_req = 'required';
                                @endphp
                            @elseif(old('second_insurance_coverage') == 'No')
                                @php
                                $secInsCovOpt = 'd-none';
                                $sec_req = '';
                                @endphp
                            @endif
                            <div id="sec_insu_dtl_div" class="{{ $secInsCovOpt ?? 'd-none' }}">
                                <div class="col-lg-12 mt-3">
                                    <div class="custom-form-field mb-5">
                                        <label for="second_insu_comp_name" class="d-flex justify-content-start">Second Insurance Company Name<span class="text-danger" id="sec_ins_comp_span"> {{ (isset($sec_req))? '*' : '' }}</span></label>
                                        <input type="text" name="second_insu_comp_name" id="second_insu_comp_name" class="form-control" placeholder="Second Insurance Company Name" value="{{ old('second_insu_comp_name') }}" {{ $sec_req ?? '' }} onblur="document.getElementById('secnd_insu_comp_error').innerHTML=''">
                                        <div class="text-danger text-start" id="secnd_insu_comp_error"></div>
                                        @error('second_insu_comp_name')
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-3 mb-5">
                                    <div class="custom-form-field">
                                        <label for="primary_member_name_2" class="d-flex justify-content-start">Primary Member<span class="text-danger" id="sec_pri_mem_span"> {{ (isset($sec_req)) ? '*' : '' }}</span></label>
                                        <input type="text" name="primary_member_name_2" id="primary_member_name_2" class="form-control" placeholder="Primary Name" value="{{ old('primary_member_name_2') }}" {{ $sec_req ?? '' }} onblur="document.getElementById('primem2_error').innerHTML=''">
                                        <div class="text-danger text-start" id="primem2_error"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <div class="custom-form-field">
                                        <label class="d-flex justify-content-start">Primary Member Date of Birth<span class="text-danger" id="sec_pri_mem_dobspan"> {{ (isset($sec_req))? '*' : '' }}</span></label>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                @php
                                                    $currentYear = date('Y');
                                                    $startYear = $currentYear - 80; // 100 years ago
                                                @endphp
                                                <select name="pm2_dob_y" id="pm2_dob_y" class="form-select" onchange="setDaysCount(document.getElementById('pm2_dob_m').value, 'pm2_dob_d', 'pm2_dob_y');">
                                                    <option value="">Year</option>
                                                    @foreach(range($currentYear, $startYear) as $year)
                                                        <option value="{{ $year }}" {{ old('pm2_dob_y') == $year ? 'selected' : '' }}>
                                                            {{ $year }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                @php
                                                $mnth = ['01'=>'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];
                                                @endphp
                                                <select name="pm2_dob_m" id="pm2_dob_m" class="form-select" onchange="setDaysCount(this.value, 'pm2_dob_d', 'pm2_dob_y');">
                                                    <option value="">Month</option>
                                                    @foreach(range(1, 12) as $month)
                                                    @php
                                                        $formattedMonth = sprintf('%02d', $month);
                                                    @endphp
                                                        <option value="{{ $formattedMonth }}" {{ old('pm2_dob_m') == $formattedMonth ? 'selected' : '' }}>
                                                            {{ $mnth[$formattedMonth] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <select name="pm2_dob_d" id="pm2_dob_d" class="form-select">
                                                    @php
                                                        $selectedMonth = old('pm2_dob_m');
                                                        $selectedYear  = old('pm2_dob_y');
                                                        $days = ($selectedMonth && $selectedYear)
                                                            ? cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear)
                                                            : '';
                                                    @endphp
                                                    @if($days)
                                                    @for($day = 1; $day <= $days; $day++)
                                                        <option value="{{ $day }}"
                                                            {{ old('pm2_dob_d') == $day ? 'selected' : '' }}>
                                                            {{ $day }}
                                                        </option>
                                                    @endfor
                                                    @else
                                                    <option value="">Date</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="text-danger text-start" id="pm2dob_error"></div>
                                        {{-- <input type="text" name="primary_member_dob_2" id="primary_member_dob_2" class="form-control mb-5" placeholder="Primary Member Date of Birth"> --}}
                                        @error('pm2_dob_y')
                                        <div class="text-danger">Invalid Date of Birth</div>
                                        @enderror
                                        
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-3 mb-5">
                                    <div class="custom-form-field">
                                        <label for="contract_policy_plan_no_2" class="d-flex justify-content-start">Enter Your Plan Policy Number<span class="text-danger" id="cont_pol_plan_span"> {{ (isset($sec_req)) ? '*' : '' }}</span></label>
                                        <input type="text" name="contract_policy_plan_no_2" id="contract_policy_plan_no_2" class="form-control" placeholder="Enter Your Plan Policy number" value="{{ old('contract_policy_plan_no_2') }}" onblur="document.getElementById('contr_polcyno2_error').innerHTML=''">
                                        <div class="text-danger text-start" id="contr_polcyno2_error"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-3 mb-5">
                                    <div class="custom-form-field">
                                        <label for="member_certificate_no_2" class="d-flex justify-content-start">MEMBER/ CERTIFICATE #: (include all zeros)<span class="text-danger" id="sec_mem_certi_span">  {{ (isset($sec_req)) ? '*' : '' }}</span></label>
                                        <input type="text" name="member_certificate_no_2" id="member_certificate_no_2" class="form-control" placeholder="Member ID" value="{{ old('member_certificate_no_2') }}" onblur="document.getElementById('mem_certino_error').innerHTML=''">
                                        <div class="text-danger text-start" id="mem_certino_error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 text-start mt-5">
                                <div class="iq-btn-container">
                                    <button class="iq-button text-capitalize border-0" type="submit" name="submit_form" value="two">
                                        <span class="iq-btn-text-holder position-relative">Click to validate</span>
                                        <span class="iq-btn-icon-holder">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                                <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    <p>and continue to next section</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="row {{ $showPart3 }}" id="part_3">
                <div class="col-lg-12">
                    <div class="row mt-4">
                        <div class="iq-title-box">
                            <span class="iq-subtitle text-uppercase">Patient Health History</span>
                            <p class="iq-title-desc text-body mt-3 mb-0">
                                We are here and always ready to help you.
                            </p>
                        </div>
                    </div>
                    <form id="frmMedicalForm_3" action="{{ route('save_medical_form') }}" method="post">
                        @csrf
                        <input type="hidden" name="customer_id" value="{{ $customer_id }}">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="v_accident_or_injured" class="d-flex justify-content-start">Were you recently involved in a Motor Vehicle Accident OR injured at work?</label>
                                <div class="d-flex mt-3">
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="v_accident_or_injured" id="v_accident_or_injured1" value="Yes" {{ old('v_accident_or_injured') == 'Yes' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="v_accident_or_injured1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="v_accident_or_injured" id="v_accident_or_injured2" value="No" {{ old('v_accident_or_injured') == 'No' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="v_accident_or_injured2">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="custom-form-field">
                                    <label class="d-flex justify-content-start">If yes, please provide all pertinent information such as date of incident, type of injury, Insurance company and claim number, Adjuster's name: <span class="text-danger" id="aperinfo"></span></label>
                                    <textarea name="all_pertinent_infomation" id="all_pertinent_infomation" placeholder="Your Message" class="form-control" onblur="document.getElementById('all_pertiinfo_error').innerHTML=''">{{ old('all_pertinent_infomation') }}</textarea>
                                    <div class="text-danger text-start" id="all_pertiinfo_error"></div>
                                    @error('all_pertinent_infomation')
                                    <div class="text-danger text-start">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 mt-5 mb-5">
                                <div class="custom-form-field">
                                    <label class="d-flex justify-content-start">Any other current injuries or illnesses, and their treatment in progress:</label>
                                    <input type="text" name="other_current_injuries" id="other_current_injuries" placeholder="Any Other Current Injuries" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6 mt-5 mb-5">
                                <div class="custom-form-field">
                                    <label class="d-flex justify-content-start">Primary reason for requesting Massage Therapy: <span class="text-danger">*</span></label>
                                    <input type="text" name="primary_complaint" id="primary_complaint" value="{{ old('primary_complaint') }}" placeholder="Primary Complaint" class="form-control" onblur="document.getElementById('primary_complaint_error').innerHTML=''">
                                    <div class="text-danger text-start" id="primary_complaint_error"></div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label class="d-flex justify-content-start">Did a health care practitioner refer you for Massage? <span class="text-danger">*</span></label>
                                <div class="d-flex mt-3">
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="refer_by_practitioner" id="refer_by_practitioner1" value="Yes" {{ old('refer_by_practitioner') == 'Yes' ? 'checked' : '' }} onchange="document.getElementById('referbypracti_error').innerHTML=''">
                                        <label class="form-check-label" for="refer_by_practitioner1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="refer_by_practitioner" id="refer_by_practitioner2" value="No" {{ old('refer_by_practitioner') == 'No' ? 'checked' : '' }} onchange="document.getElementById('referbypracti_error').innerHTML=''">
                                        <label class="form-check-label" for="refer_by_practitioner2">No</label>
                                    </div>
                                </div>
                                <div class="text-danger text-start" id="referbypracti_error"></div>
                                @error('refer_by_practitioner')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="custom-form-field">
                                    <label class="d-flex justify-content-start">Name of your Primary/Family Physician<span class="text-danger">*</span></label><small>(This information is Mandatory. If patient has no primary health care provider, please provide name of the last physician visited.)</small>
                                    <input type="text" name="health_cre_profess_name" id="health_cre_profess_name" value="{{ old('health_cre_profess_name') }}" placeholder="Enter the Name of your Primary/Family Physician" class="form-control" onblur="document.getElementById('hlth_carprofesnm_error').innerHTML=''">
                                    <div class="text-danger text-start" id="hlth_carprofesnm_error"></div>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-5">
                                <div class="custom-form-field">
                                    <label class="d-flex justify-content-start">Physician's practice facility information<span class="text-danger">*</span> <small>Please provide at least one of the following</small>:</label>
                                    <input type="text" name="family_doc_addrs" id="family_doc_addrs" placeholder="Phone/Address/City/Clinic Name" value="{{ old('family_doc_addrs') }}" class="form-control" onblur="document.getElementById('famdocaddr_error').innerHTML=''">
                                    <div class="text-danger text-start" id="famdocaddr_error"></div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="d-flex justify-content-start">Have you had Massage Therapy before? <span class="text-danger">*</span></label>
                                <div class="d-flex mt-3">
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="received_massage_before" id="received_massage_before1" value="Yes" {{ old('received_massage_before') == 'Yes' ? 'checked' : '' }} onchange="document.getElementById('recmassbefo_error').innerHTML=''">
                                        <label class="form-check-label" for="received_massage_before1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="received_massage_before" id="received_massage_before2" value="No" {{ old('received_massage_before') == 'No' ? 'checked' : '' }} onchange="document.getElementById('recmassbefo_error').innerHTML=''">
                                        <label class="form-check-label" for="received_massage_before2">No</label>
                                    </div>
                                </div>
                                <div class="text-danger text-start" id="recmassbefo_error"></div>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <label class="d-flex justify-content-start">Are you currently receiving other treatments from any other health care professional? <span class="text-danger">*</span></label>
                                <div class="d-flex mt-3">
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="received_treatment_from_another" id="received_treatment_from_another1" value="Yes" {{ old('received_treatment_from_another') == 'Yes' ? 'checked' : '' }} onchange="document.getElementById('receive_treat_frm_ano_error').innerHTML=''">
                                        <label class="form-check-label" for="received_treatment_from_another1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="received_treatment_from_another" id="received_treatment_from_another2" value="No" {{ old('received_treatment_from_another') == 'No' ? 'checked' : '' }} onchange="document.getElementById('receive_treat_frm_ano_error').innerHTML=''">
                                        <label class="form-check-label" for="received_treatment_from_another2">No</label>
                                    </div>
                                </div>
                                <div class="text-danger text-start" id="receive_treat_frm_ano_error"></div>
                            </div>
                            <div class="col-lg-12 mt-4 mb-5">
                                <div class="custom-form-field">
                                    <label class="d-flex justify-content-start">If yes, please provide type of treatment <span class="text-danger" id="if_yes_teat_span"></span> (chiropractic, physiotherapy, etc.):</label>
                                    <input type="text" name="if_yes_treatment_type" id="if_yes_treatment_type" placeholder="Treatment Type" value="{{ old('if_yes_treatment_type') }}" class="form-control" onblur="document.getElementById('ifyestreattyp_error').innerHTML=''">
                                    <div class="text-danger text-start" id="ifyestreattyp_error"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <div class="custom-form-field">
                                    <label class="d-flex justify-content-start">Current Medications:</label>
                                    <input name="current_medications" id="current_medications" placeholder="Current Medications" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="d-flex justify-content-start">Do you have any Allergies <span class="text-danger">*</span></label>
                                <div class="d-flex mt-3">
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="any_allergies" id="any_allergies1" value="Yes" {{ old('any_allergies') == 'Yes' ? 'checked' : '' }} onchange="document.getElementById('anyallerg_error').innerHTML=''">
                                        <label class="form-check-label" for="any_allergies1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="any_allergies" id="any_allergies2" value="No" {{ old('any_allergies') == 'No' ? 'checked' : '' }} onchange="document.getElementById('anyallerg_error').innerHTML=''">
                                        <label class="form-check-label" for="any_allergies2">No</label>
                                    </div>
                                </div>
                                <div class="text-danger text-start" id="anyallerg_error"></div>
                            </div>
                            <div class="col-lg-12 mb-5">
                                <div class="custom-form-field">
                                    <label class="d-flex justify-content-start">Please list all allergies (Seasonal, Foods, Scents, etc): <span class="text-danger" id="all_aller_lst"></span></label>
                                    <input type="text" name="allergy_lst" id="allergy_lst" placeholder="List of allergies" value="{{ old('allergy_lst') }}" class="form-control" onblur="document.getElementById('allergylst_error').innerHTML=''">
                                    <div class="text-danger text-start" id="allergylst_error"></div>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-5">
                                <div class="custom-form-field">
                                    <label class="d-flex justify-content-start">Please list all surgeries and approximate dates:</label>
                                    <input type="text" name="list_all_surgeries" id="list_all_surgeries" value="{{ old('list_all_surgeries') }}" placeholder="List all Surgeries and Approx date(s)" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="custom-form-field">
                                    <label class="d-flex justify-content-start"><strong>Please indicate conditions you are experiencing or have experienced:</strong></label>
                                </div>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label class="d-flex justify-content-start fw-bold"><strong>Cardiovascular:</strong></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cardiovascular[]" id="cardiovascular_1" value="High Blood Pressure" {{ in_array('High Blood Pressure', old('cardiovascular', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="cardiovascular_1">
                                        High Blood Pressure
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cardiovascular[]" id="cardiovascular_2" value="Low Blood Pressure" {{ in_array('Low Blood Pressure', old('cardiovascular', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="cardiovascular_2">
                                        Low Blood Pressure
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cardiovascular[]" id="cardiovascular_3" value="Chronic Congestive Heart Failure" {{ in_array('Chronic Congestive Heart Failure', old('cardiovascular', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="cardiovascular_3">
                                        Chronic Congestive Heart Failure
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cardiovascular[]" id="cardiovascular_4" value="Heart Attack" {{ in_array('Heart Attack', old('cardiovascular', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="cardiovascular_4">
                                        Heart Attack
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cardiovascular[]" id="cardiovascular_5" value="Heart Disease" {{ in_array('Heart Disease', old('cardiovascular', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="cardiovascular_5">
                                        Heart Disease
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cardiovascular[]" id="cardiovascular_6" value="Heart Palpations" {{ in_array('Heart Palpations', old('cardiovascular', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="cardiovascular_6">
                                        Heart Palpations
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cardiovascular[]" id="cardiovascular_7" value="Heart Murmur" {{ in_array('Heart Murmur', old('cardiovascular', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="cardiovascular_7">
                                        Heart Murmur
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cardiovascular[]" id="cardiovascular_8" value="Stroke / CVA" {{ in_array('Stroke / CVA', old('cardiovascular', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="cardiovascular_8">
                                        Stroke / CVA
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cardiovascular[]" id="cardiovascular_9" value="Aneurism" {{ in_array('Aneurism', old('cardiovascular', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="cardiovascular_9">
                                        Aneurism
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cardiovascular[]" id="cardiovascular_10" value="Angina" {{ in_array('Angina', old('cardiovascular', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="cardiovascular_10">
                                        Angina
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cardiovascular[]" id="cardiovascular_13" value="Phlebitis / Varicose" {{ in_array('Phlebitis / Varicose', old('cardiovascular', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="cardiovascular_13">
                                        Phlebitis / Varicose
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cardiovascular[]" id="cardiovascular_14" value="Poor Blood Circulation" {{ in_array('Poor Blood Circulation', old('cardiovascular', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="cardiovascular_14">
                                        Poor Blood Circulation
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cardiovascular[]" id="cardiovascular_15" value="Pacemaker or Similar Device" {{ in_array('Pacemaker or Similar Device', old('cardiovascular', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="cardiovascular_15">
                                        Pacemaker or Similar Device
                                    </label>
                                </div>
                                
                            </div>
                            <div class="col-lg-4 mt-4">
                                <label class="d-flex justify-content-start fw-bold">Gastrointestinal:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gastrointestinal[]" id="gastrointestinal_1" value="Constipation" {{ in_array('Constipation', old('gastrointestinal', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="gastrointestinal_1">
                                        Constipation
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gastrointestinal[]" id="gastrointestinal_2" value="Diarrhea" {{ in_array('Diarrhea', old('gastrointestinal', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="gastrointestinal_2">
                                        Diarrhea
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gastrointestinal[]" id="gastrointestinal_3" value="Gas / Bloating" {{ in_array('Gas / Bloating', old('gastrointestinal', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="gastrointestinal_3">
                                        Gas / Bloating
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gastrointestinal[]" id="gastrointestinal_4" value="Nausea / Vomiting" {{ in_array('Nausea / Vomiting', old('gastrointestinal', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="gastrointestinal_4">
                                        Nausea / Vomiting
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gastrointestinal[]" id="gastrointestinal_5" value="Irritable Bowel Syndrome" {{ in_array('Irritable Bowel Syndrome', old('gastrointestinal', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="gastrointestinal_5">
                                        Irritable Bowel Syndrome
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gastrointestinal[]" id="gastrointestinal_6" value="Crohn's / Colitis" {{ in_array("Crohn\'s / Colitis", old('gastrointestinal', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="gastrointestinal_6">
                                        Crohn's / Colitis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gastrointestinal[]" id="gastrointestinal_7" value="Hernia" {{ in_array('Hernia', old('gastrointestinal', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="gastrointestinal_7">
                                        Hernia
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gastrointestinal[]" id="gastrointestinal_8" value="Ulcers" {{ in_array('Ulcers', old('gastrointestinal', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="gastrointestinal_8">
                                        Ulcers
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gastrointestinal[]" id="gastrointestinal_9" value="Gall Bladder Problems" {{ in_array('Gall Bladder Problems', old('gastrointestinal', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="gastrointestinal_9">
                                        Gall Bladder Problems
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gastrointestinal[]" id="gastrointestinal_10" value="Liver Problems" {{ in_array('Liver Problems', old('gastrointestinal', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="gastrointestinal_10">
                                        Liver Problems
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gastrointestinal[]" id="gastrointestinal_11" value="Kidney Infections" {{ in_array('Kidney Infections', old('gastrointestinal', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="gastrointestinal_11">
                                        Kidney Infections
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gastrointestinal[]" id="gastrointestinal_12" value="Bladder Infections" {{ in_array('Bladder Infections', old('gastrointestinal', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="gastrointestinal_12">
                                        Bladder Infections
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gastrointestinal[]" id="gastrointestinal_13" value="Urination Problems" {{ in_array('Urination Problems', old('gastrointestinal', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="gastrointestinal_13">
                                        Urination Problems
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gastrointestinal[]" id="gastrointestinal_14" value="Poor Appetite" {{ in_array('Poor Appetite', old('gastrointestinal', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="gastrointestinal_14">
                                        Poor Appetite
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gastrointestinal[]" id="gastrointestinal_15" value="Excessive Thirst" {{ in_array('Excessive Thirst', old('gastrointestinal', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="gastrointestinal_15">
                                        Excessive Thirst
                                    </label>
                                </div>
                                
                            </div>
                            <div class="col-lg-4 mt-4">
                                <label class="d-flex justify-content-start fw-bold">Muscle / Joint:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="muscle_joint[]" id="muscle_joint_1" value="Muscle Strain" {{ in_array('Muscle Strain', old('muscle_joint', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="muscle_joint_1">
                                        Muscle Strain
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="muscle_joint[]" id="muscle_joint_2" value="Ligament Sprain" {{ in_array('Ligament Sprain', old('muscle_joint', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="muscle_joint_2">
                                        Ligament Sprain
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="muscle_joint[]" id="muscle_joint_3" value="Spasms / Cramps" {{ in_array('Spasms / Cramps', old('muscle_joint', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="muscle_joint_3">
                                        Spasms / Cramps
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="muscle_joint[]" id="muscle_joint_4" value="Tendinitis" {{ in_array('Tendinitis', old('muscle_joint', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="muscle_joint_4">
                                        Tendinitis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="muscle_joint[]" id="muscle_joint_5" value="Bursitis" {{ in_array('Bursitis', old('muscle_joint', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="muscle_joint_5">
                                        Bursitis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="muscle_joint[]" id="muscle_joint_6" value="Fibromyalgia" {{ in_array('Fibromyalgia', old('muscle_joint', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="muscle_joint_6">
                                        Fibromyalgia
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="muscle_joint[]" id="muscle_joint_7" value="Ankylosing Spondylitis" {{ in_array('Ankylosing Spondylitis', old('muscle_joint', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="muscle_joint_7">
                                        Ankylosing Spondylitis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="muscle_joint[]" id="muscle_joint_8" value="Arthritis" {{ in_array('Arthritis', old('muscle_joint', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="muscle_joint_8">
                                        Arthritis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="muscle_joint[]" id="muscle_joint_10" value="Herniated Disc" {{ in_array('Herniated Disc', old('muscle_joint', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="muscle_joint_10">
                                        Herniated Disc
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="muscle_joint[]" id="muscle_joint_11" value="Degenerative Discs" {{ in_array('Degenerative Discs', old('muscle_joint', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="muscle_joint_11">
                                        Degenerative Discs
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="muscle_joint[]" id="muscle_joint_12" value="Joint or Bone Disease" {{ in_array('Joint or Bone Disease', old('muscle_joint', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="muscle_joint_12">
                                        Joint or Bone Disease
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="muscle_joint[]" id="muscle_joint_13" value="Scoliosis" {{ in_array('Scoliosis', old('muscle_joint', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="muscle_joint_13">
                                        Scoliosis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="muscle_joint[]" id="muscle_joint_14" value="Dislocation" {{ in_array('Dislocation', old('muscle_joint', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="muscle_joint_14">
                                        Dislocation
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="muscle_joint[]" id="muscle_joint_15" value="Fracture" {{ in_array('Fracture', old('muscle_joint', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="muscle_joint_15">
                                        Fracture
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-4 mt-4">
                                <label class="d-flex justify-content-start fw-bold">Respiratory:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="respiratory[]" id="respiratory_1" value="Chronic Cough" {{ in_array('Chronic Cough', old('respiratory', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="respiratory_1">
                                        Chronic Cough
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="respiratory[]" id="respiratory_2" value="Shortness of Breath" {{ in_array('Shortness of Breath', old('respiratory', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="respiratory_2">
                                        Shortness of Breath
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="respiratory[]" id="respiratory_3" value="Bronchitis" {{ in_array('Bronchitis', old('respiratory', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="respiratory_3">
                                        Bronchitis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="respiratory[]" id="respiratory_4" value="Asthma" {{ in_array('Asthma', old('respiratory', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="respiratory_4">
                                        Asthma
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="respiratory[]" id="respiratory_5" value="Emphysema" {{ in_array('Emphysema', old('respiratory', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="respiratory_5">
                                        Emphysema
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="respiratory[]" id="respiratory_6" value="Pneumonia" {{ in_array('Pneumonia', old('respiratory', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="respiratory_6">
                                        Pneumonia
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="respiratory[]" id="respiratory_7" value="Tuberculosis" {{ in_array('Tuberculosis', old('respiratory', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="respiratory_7">
                                        Tuberculosis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="respiratory[]" id="respiratory_9" value="Sinus Congestion" {{ in_array('Sinus Congestion', old('respiratory', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="respiratory_9">
                                        Sinus Congestion
                                    </label>
                                </div>
                                
                            </div>

                            <div class="col-lg-4 mt-4">
                                <label class="d-flex justify-content-start fw-bold">Skin:</label>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="skin[]" id="skin_1" value="Hypersensitivity" {{ in_array('Hypersensitivity', old('skin', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="skin_1">
                                        Hypersensitivity
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="skin[]" id="skin_2" value="Bruises Easily" {{ in_array('Bruises Easily', old('skin', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="skin_2">
                                        Bruises Easily
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="skin[]" id="skin_3" value="Eczema" {{ in_array('Eczema', old('skin', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="skin_3">
                                        Eczema
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="skin[]" id="skin_4" value="Psoriasis" {{ in_array('Psoriasis', old('skin', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="skin_4">
                                        Psoriasis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="skin[]" id="skin_5" value="Athletes Foot" {{ in_array('Athletes Foot', old('skin', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="skin_5">
                                        Athletes Foot
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="skin[]" id="skin_6" value="Herpes" {{ in_array('Herpes', old('skin', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="skin_6">
                                        Herpes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="skin[]" id="skin_7" value="Warts" {{ in_array('Warts', old('skin', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="skin_7">
                                        Warts
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-4">
                                <label class="d-flex justify-content-start fw-bold">Head / Neck:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="head_neck[]" id="head_neck_1" value="Headaches" {{ in_array('Headaches', old('head_neck', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="head_neck_1">
                                        Headaches
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="head_neck[]" id="head_neck_3" value="Whiplash" {{ in_array('Whiplash', old('head_neck', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="head_neck_3">
                                        Whiplash
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="head_neck[]" id="head_neck_4" value="Chronic Jaw Pain" {{ in_array('Chronic Jaw Pain', old('head_neck', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="head_neck_4">
                                        Chronic Jaw Pain
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="head_neck[]" id="head_neck_5" value="Chronic Ear Pain" {{ in_array('Chronic Ear Pain', old('head_neck', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="head_neck_5">
                                        Chronic Ear Pain
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="head_neck[]" id="head_neck_6" value="Hearing Loss / Issues" {{ in_array('Hearing Loss / Issues', old('head_neck', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="head_neck_6">
                                        Hearing Loss / Issues
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="head_neck[]" id="head_neck_7" value="Vision Loss / Issues" {{ in_array('Vision Loss / Issues', old('head_neck', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="head_neck_7">
                                        Vision Loss / Issues
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-lg-12 mt-4">
                                <label class="d-flex justify-content-start fw-bold">Other Conditions:</label>
                                <div class="form-check d-flex align-items-center gap-3">
                                    <input class="form-check-input" type="checkbox" name="other_conditions[]" id="other_conditions_1" value="Diabetes" {{ in_array('Diabetes', old('other_conditions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="other_conditions_1">
                                        Diabetes
                                    </label>
                                    <input type="text" name="diabetes_type" class="form-control form-control-sm w-25" style="height: 40px;" placeholder="Type" value="{{ old('diabetes_type') }}">
                                </div>
                                
                                <div class="form-check d-flex align-items-center gap-3">
                                    <input class="form-check-input" type="checkbox" name="other_conditions[]" id="other_conditions_2" value="Cancer" {{ in_array('Cancer', old('other_conditions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="other_conditions_2">
                                        Cancer
                                    </label>
                                    <input type="text" name="cancer_type" class="form-control form-control-sm w-25" style="height: 40px;" placeholder="Type" value="{{ old('cancer_type') }}">
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="other_conditions[]" id="other_conditions_3" value="Multiple Sclerosis" {{ in_array('Multiple Sclerosis', old('other_conditions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="other_conditions_3">
                                        Multiple Sclerosis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="other_conditions[]" id="other_conditions_4" value="Epilepsy" {{ in_array('Epilepsy', old('other_conditions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="other_conditions_4">
                                        Epilepsy
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="other_conditions[]" id="other_conditions_5" value="Thyroid Disorders" {{ in_array('Thyroid Disorders', old('other_conditions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="other_conditions_5">
                                        Thyroid Disorders
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="other_conditions[]" id="other_conditions_6" value="Lupus" {{ in_array('Lupus', old('other_conditions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="other_conditions_6">
                                        Lupus
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="other_conditions[]" id="other_conditions_7" value="Loss of Sensation" {{ in_array('Loss of Sensation', old('other_conditions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="other_conditions_7">
                                        Loss of Sensation
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="other_conditions[]" id="other_conditions_8" value="Insomnia / Fatigue" {{ in_array('Insomnia / Fatigue', old('other_conditions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="other_conditions_8">
                                        Insomnia / Fatigue
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="other_conditions[]" id="other_conditions_9" value="Fainting / Dizziness" {{ in_array('Fainting / Dizziness', old('other_conditions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="other_conditions_9">
                                        Fainting / Dizziness
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="other_conditions[]" id="other_conditions_10" value="Anxiety / Nervousness" {{ in_array('Anxiety / Nervousness', old('other_conditions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="other_conditions_10">
                                        Anxiety / Nervousness
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="other_conditions[]" id="other_conditions_11" value="Depression" {{ in_array('Depression', old('other_conditions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="other_conditions_11">
                                        Depression
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="other_conditions[]" id="other_conditions_12" value="Alcohol / Drug Addiction" {{ in_array('Alcohol / Drug Addiction', old('other_conditions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="other_conditions_12">
                                        Alcohol / Drug Addiction
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <label class="d-flex justify-content-start">Is there a family history of any of the conditions listed above?</label>
                                <div class="d-flex mt-3">
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="is_family_history" id="is_family_history1" value="Yes" {{ old('is_family_history') == 'Yes' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_family_history1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="is_family_history" id="is_family_history2" value="No" {{ old('is_family_history') == 'No' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_family_history2">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <label class="d-flex justify-content-start">Do you have any internal pins, wires, artificial joints or special equipment?<span class="text-danger">*</span></label>
                                <div class="d-flex mt-3">
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="internal_pin_wire_joint" id="internal_pin_wire_joint1" value="Yes" {{ old('internal_pin_wire_joint') == 'Yes' ? 'checked' : '' }} onchange="document.getElementById('inter_pin_wir_jon_error').innerHTML=''">
                                        <label class="form-check-label" for="internal_pin_wire_joint1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="internal_pin_wire_joint" id="internal_pin_wire_joint2" value="No" {{ old('internal_pin_wire_joint') == 'No' ? 'checked' : '' }} onchange="document.getElementById('inter_pin_wir_jon_error').innerHTML=''">
                                        <label class="form-check-label" for="internal_pin_wire_joint2">No</label>
                                    </div>
                                </div>
                                <div class="text-danger text-start" id="inter_pin_wir_jon_error"></div>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="custom-form-field">
                                    <label for="joint_or_pin_text" class="d-flex justify-content-start">If yes, where? <span class="text-danger" id="jonpin_span"></span></label>
                                    <input type="text" name="joint_or_pin_text" id="joint_or_pin_text" class="form-control" placeholder="Internal Pin Wire Joint Text" onblur="document.getElementById('jot_pin_txt_error').innerHTML=''">
                                    <div class="text-danger text-start" id="jot_pin_txt_error"></div>
                                    @error('joint_or_pin_text')
                                    <div class="text-danger text-start">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label class="d-flex justify-content-start">Your General Health </label>
                                <div class="d-flex mt-3">
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="good_health" id="good_health1" value="Good" {{ old('good_health') == 'Good' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="good_health1">Good</label>
                                    </div>
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="good_health" id="good_health2" value="Fair" {{ old('good_health') == 'Fair' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="good_health2">Fair</label>
                                    </div>
                                    <div class="form-check form-check-inline justify-content-start">
                                        <input class="form-check-input" type="radio" name="good_health" id="good_health3" value="Poor" {{ old('good_health') == 'Poor' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="good_health3">Poor</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 mt-5">
                                <div class="row">
                                    <h5 >For Female Patients</h5>
                                    <div class="col-lg-6">
                                        <label class="d-flex justify-content-start">Are you currently pregnant?</label>
                                        <div class="d-flex mt-3">
                                            <div class="form-check form-check-inline justify-content-start">
                                                <input class="form-check-input" type="radio" name="pregnant" id="pregnant1" value="Yes" {{ old('pregnant') == 'Yes' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pregnant1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline justify-content-start">
                                                <input class="form-check-input" type="radio" name="pregnant" id="pregnant2" value="No" {{ old('pregnant') == 'No' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pregnant2">No</label>
                                            </div>
                                            <div class="form-check form-check-inline justify-content-start">
                                                <input class="form-check-input" type="radio" name="pregnant" id="pregnant3" value="N/A" {{ old('pregnant') == 'N/A' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pregnant3">N/A</label>
                                            </div>
                                        </div>
                                        <label class="d-flex justify-content-start d-none" id="due_dt_lbl">Due Date: </label>
                                        <input class="form-control d-none" style="height: 40px; width: 150px;" type="date" name="pregnant_due_date" id="pregnant_due_date" value="" placeholder="Due Date">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="d-flex justify-content-start">Have you given birth within last three months?</label>
                                        <div class="d-flex mt-3">
                                            <div class="form-check form-check-inline justify-content-start">
                                                <input class="form-check-input" type="radio" name="pregnant_in_three_month" id="pregnant_in_three_month1" value="Yes" {{ old('pregnant') == 'Yes' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pregnant_in_three_month1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline justify-content-start">
                                                <input class="form-check-input" type="radio" name="pregnant_in_three_month" id="pregnant_in_three_month2" value="No" {{ old('pregnant') == 'No' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pregnant_in_three_month2">No</label>
                                            </div>
                                            <div class="form-check form-check-inline justify-content-start">
                                                <input class="form-check-input" type="radio" name="pregnant_in_three_month" id="pregnant_in_three_month3" value="N/A" {{ old('pregnant') == 'N/A' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pregnant_in_three_month3">N/A</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 text-start mt-5">
                                <div class="iq-btn-container">
                                <button class="iq-button text-capitalize border-0" type="submit" name="submit_form" value="three">
                                    <span class="iq-btn-text-holder position-relative">Click to validate</span>
                                    <span class="iq-btn-icon-holder">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                            <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </button>
                                <p>and continue to next section</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="row {{$showPart4}}" id="part_4">
                <div class="col-lg-12">
                    <form id="frmMedicalForm_4" action="{{ route('save_medical_form') }}" method="post">
                        @csrf
                        <div class="row mt-5">
                            <input type="hidden" name="customer_id" value="{{ $customer_id }}">
                            <div class="iq-title-box">
                                <span class="iq-subtitle text-uppercase">Acknowledgement And Consent</span>
                                <p class="iq-title-desc text-body mt-3 mb-0">
                                We are here and always ready to help you.
                                </p>
                            </div>

                            <div class="col-lg-12">
                                <p class="text-start mb-0"><span class="fw-bold fs-5">Consent to Treatment & Patient Rights:</span></p>
                                <p class="text-start">Registered Massage Therapy at the Clinic is provided by a therapist in accordance with the standards of practice and professional requirements established by the College of Massage Therapists of Ontario (CMTO).</p>
                                <p class="text-start">Prior to treatment, the proposed plan of care will be explained to you, including its expected benefits, potential risks, and reasonable alternatives. You will have the opportunity to ask questions before treatment begins. Your informed consent is required prior to treatment and may be provided verbally or in writing. Consent is an ongoing process and may be modified or withdrawn by you at any time.</p>
                                <p class="text-start">You have the right to decline any assessment or treatment, request modifications to techniques or areas treated, or discontinue treatment at any time. Withdrawal of consent will not affect your ability to access future services unless safety, ethical, or professional boundary concerns arise.</p>
                                <p class="text-start">If a patient is unable to provide informed consent due to age or capacity, consent will be obtained from a legally authorized Substitute Decision Maker. The Clinic follows Ontario consent laws and professional standards when determining capacity and will involve patients in decision-making to the greatest extent possible.</p>
                                <p class="text-start">Registered Massage Therapy is not a substitute for medical diagnosis or emergency medical care, and therapists do not diagnose medical conditions. If you are experiencing a medical emergency, you should contact 911 or seek immediate medical attention.</p>

                                <p class="text-start mb-0"><span class="fw-bold fs-5">Privacy & Health Information Protection</span></p>
                                <p class="text-start">Your personal and personal health information is collected, used, and protected in accordance with Ontario's Personal Health Information Protection Act (PHIPA). Information is collected for the purposes of providing safe and effective treatment, maintaining clinical records, processing payments and insurance claims, communicating regarding appointments, and meeting legal and regulatory obligations. Your information will not be disclosed without your consent unless required or permitted by law.</p>
                                <p class="text-start">Clinical records are retained in accordance with guidelines established by the College of Massage Therapists of Ontario. Adult records are maintained for a minimum of ten years from the date of last treatment. Records for minors are retained for at least ten years after the individual reaches eighteen years of age. You may request access to your records, and reasonable administrative fees may apply for copies or third-party reports. The Clinic's directors serve as custodians of your health information.</p>
                                <p class="text-start">Electronic communication, including email and text messaging, is the primary method used by the Clinic for appointment scheduling, confirmations, reminders, and the issuance of invoices or receipts. While reasonable safeguards are in place, including secure electronic record systems and controlled access, electronic communication carries inherent privacy risks. By providing your contact information, you consent to the use of these methods.</p>
                                <p class="text-start">The Clinic does not sell, rent, trade, or share your private information with unauthorized third parties.</p>
                                
                                <p class="text-start mb-0"><span class="fw-bold fs-5">Professional Standards &amp; Safety: </span></p>
                                <p class="text-start">The Clinic is committed to maintaining a safe, respectful, and professional environment. Treatment is provided within the scope of practice for Massage Therapy and in accordance with regulatory standards. While every effort is made to provide safe and effective care, outcomes may vary and results are not guaranteed.</p>
                                <p class="text-start">Massage Therapy is not a substitute for medical diagnosis or emergency care, and the therapist does not diagnose medical conditions. If you are experiencing a medical emergency, you should contact 911 or seek immediate medical attention.</p>
                                <p class="text-start">The Clinic follows applicable public health and infection prevention standards, including appropriate hand hygiene, equipment sanitation, and laundering procedures. Inappropriate, unsafe, or abusive behaviour will not be tolerated, and treatment may be refused or discontinued if safety or professional boundaries are compromised.</p>
                                <p class="text-start">The Clinic complies with the Ontario Human Rights Code and the Accessibility for Ontarians with Disabilities Act and provides services without discrimination on any protected ground. The Clinic is committed to maintaining an inclusive and accessible environment for all patients.</p>

                                <p class="text-start mb-0"><span class="fw-bold fs-5">Appointments, Fees & Payment</span></p>
                                <p class="text-start">A minimum of twenty-four (24) hours’ notice is required to cancel or reschedule an appointment. Late cancellations or missed appointments will incur the full appointment fee. Arriving late may result in reduced treatment time, with the full fee still applicable. If more than half of the scheduled appointment time has passed upon your arrival, the appointment may be considered missed and charged in full at the therapist's discretion. The Clinic may, at its discretion waive cancellation fees under reasonable circumstances. The Clinic reserves the right to cancel or reschedule appointments due to therapist illness or unforeseen circumstances.</p>
                                <p class="text-start">Payment is due at the time services are rendered. If direct billing to an insurance provider is offered as a courtesy, you remain responsible for any portion not covered. Verification of insurance coverage is the patient's responsibility. If a claim is denied or paid directly to you, the outstanding balance remains your responsibility.</p>
                                <p class="text-start">Fees will apply for services not covered by insurance, including completion of forms, reports, or record copies. Accounts not paid within thirty (30) days may be subject to administrative fees and reasonable interest charges as permitted by law. Accounts in significant arrears (90 days or more) may be referred to a third-party collection agency in accordance with applicable laws. Outstanding balances must be paid before future appointments are scheduled.</p>

                                <p class="text-start mb-0"><span class="fw-bold fs-5">Policy Updates & Concerns</span></p>
                                <p class="text-start">The Clinic reserves the right to update its policies in response to legislative, regulatory, or professional practice changes. Updated policies are effective upon posting.</p>
                                <p class="text-start">If you have questions or concerns regarding your care, you are encouraged to speak directly with the Clinic. You may also contact the College of Massage Therapists of Ontario if a concern remains unresolved.</p>

                                <p class="text-start mb-0"><span class="fw-bold fs-5">Your Consent & Authorization</span></p>
                                <p class="text-start"><em>Kindly provide your Acknowledgement.</em></p>
                                <p class="text-start">I confirm that I have disclosed all relevant health and medical information to the Clinic to the best of my knowledge and agree to promptly inform the Clinic of any changes to my health, condition, or medications.</p>
                                <p class="text-start">I authorize the Clinic's therapist to perform assessments, examinations, and treatments necessary to evaluate and manage my condition within their scope of practice. I understand that I will receive clear information about my condition, the proposed treatment, its expected benefits, material risks, reasonable alternatives, and the potential consequences of declining care. I also understand that I may withdraw my consent at any time.</p>
                                <p class="text-start">I authorize the Clinic to communicate with other regulated health care professionals as reasonably necessary for my care. I further authorize the disclosure of my personal health information to insurance providers or other authorized third parties for claims processing, care coordination, or as required or permitted by law. I understand that written authorization will be obtained where legally required.</p>
                                <p class="text-start">I acknowledge that reasonable safeguards are in place to protect my information and release the Clinic and its therapists from liability for disclosures made in good faith and in compliance with applicable law.</p>
                                <p class="text-start">If I have agreed to Benefits Assignment (Direct Billing), I assign any eligible insurance benefits to the provider submitting my claims and authorize my insurer or plan administrator to issue payment directly to the Clinic. If I am a spouse or dependent, I confirm that I am authorized by the plan member to make this assignment.</p>
                                <p class="text-start">I understand that information related to my treatment and insurance claims may be transmitted electronically.</p>
                                <div class="form-check">
                                    <input class="form-check-input" style="width:30px; height: 30px;" type="checkbox" name="acknowlege" id="acknowlege" value="Yes" {{ old('acknowlege') == 'Yes' ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="acknowlege" style="font-size: 24px; padding-left:1rem;text-align: justify;">
                                        I Acknowledge that I have read and understood the Clinic Policies outlined above. I understand my rights regarding informed consent, privacy, and withdrawal from treatment, and I agree to the terms and conditions described above. An electronic version of this authorization is as valid as the original and will remain in effect for the administration of my treatment unless withdrawn in writing.<span class="text-danger">*</span>
                                    </label>
                                    <div class="text-danger text-start" id="acknowlege_error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-lg-12">
                                <canvas id="signature-pad" class="border rounded w-100" style="height:100px;"></canvas>
                                <input type="hidden" name="signature" id="signature">
                                <button type="button" id="clear" class="btn btn-danger">Clear</button>
                                <div class="text-danger text-start" id="sig_error"></div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="custom-form-field">
                                    <label class="d-flex justify-content-start" for="acknowlegeName">Full Name <span class="text-danger">*</span> <small clas>(Parent/Guardian Name for Children under age of 16)</small></label>
                                    <input type="text" name="acknowlegeName" id="acknowlegeName" value="{{ old('acknowlegeName') }}"  class="form-control" placeholder="">
                                    <div class="text-danger text-start" id="acknm_error"></div>
                                    @error('acknowlegeName')
                                    <div class="text-danger text-start">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 mt-1">
                                <div class="custom-form-field">
                                    <input type="text" name="choose_date" id="choose_date" value="{{ old('choose_date') }}" class="form-control" placeholder="">
                                    <div class="text-danger text-start" id="chose_dt_error"></div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="acknowlege_2" id="acknowlege_2" value="Yes" {{ old('acknowlege_2') == 'Yes' ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-start" for="acknowlege_2">
                                        By typing my Full Name above, I agree that it's the electronic equivalent of my real signature. By E-Signing and submitting this document, I confirm that all provided information is true and accurate to the best of my knowledge.
                                    </label>
                                    <div class="text-danger text-start" id="acknoleg_2_error"></div>
                                    <input type="hidden" name="hdnAcknowlege" id="hdnAcknowlege" value="By typing my Full Name above, I agree that it's the electronic equivalent of my real signature. By E-Signing and submitting this document, I confirm that all provided information is true and accurate to the best of my knowledge.">
                                </div>
                            </div>

                            <div class="col-lg-12 text-start mt-5">
                                <div class="iq-btn-container">
                                <button class="iq-button text-capitalize border-0" type="submit" name="submit_form" value="four">
                                    <span class="iq-btn-text-holder position-relative">Submit</span>
                                    <span class="iq-btn-icon-holder">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                            <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </button>
                                <p>To Complete your medical intake form</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>   
            
         </div>
         <div class="col-lg-2 d-lg-block d-none"></div>
      </div>
   </div>
</div>
@endsection