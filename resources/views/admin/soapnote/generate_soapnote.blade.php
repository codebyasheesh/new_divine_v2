@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Generate Soap Note</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.soap_notes') }}">Soap Note</a></li>
            <li class="breadcrumb-item active" aria-current="page">Generate Soap Note</li>
        </ol>
        </div>
    </div>
    {{--end::Row--}}
    </div>
    {{--end::Container--}}
</div>

<div class="app-content">
    {{--begin::Container--}}
    <div class="container-fluid">
    {{--begin::Row--}}
        <div class="row g-4">
            <div class="col-md-12">
  
                  @if ($errors->any())
                    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; margin-bottom: 15px;">
                        <h3>Validation Errors:</h3>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                  @endif
                  {{--begin::Alert--}}
                  {{--begin::Form--}}
                  <form action="{{ route('admin.generate_soap_note_pdf') }}" method="post">
                    @csrf
                    <div class="card card-info card-outline mb-4">
                    {{--begin::Header--}}
                        <div class="card-header"><div class="card-title fw-bold">Generate SOAP Note</div></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Customer Name</label>
                                            <input type="text" class="form-control" id="customer_search" value="{{($detail->customer_name)??''}}" placeholder="Enter name or mobile" aria-describedby="customer_idHelp"
                                                />
                                            <div id="customer_suggestions" class="list-group"></div>
                                            <input type="hidden" name="customer_id" value="{{($detail->customer_id)??''}}">
                                            <input type="hidden" name="customer_name" value="{{($detail->customer_name)??''}}">
                                            <input type="hidden" name="customer_mobile" value="{{($detail->customer_mobile)??''}}">
                                            <input type="hidden" name="customer_email" value="{{($detail->customer_email)??''}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="appointment_date" class="form-label fw-bold">Appointment Date: <span class="text-danger">*</span></label>
                                            <input
                                            type="text"
                                            class="form-control" name="appointment_date"
                                            id="appointment_date" value="{{ get_formatted_date($detail->booking_date, 'M d, Y') }}" aria-describedby="appointment_dateHelp" />
                                            
                                            @error('appointment_date')
                                            <div id="appointment_dateHelp" class="form-text text-danger" id="error_appointment_date">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="time" class="form-label fw-bold">Time: <span class="text-danger">*</span></label>
                                            @php
                                                $tim = explode(',', $detail->time_slots);
                                            @endphp
                                            <input
                                            type="text"
                                            class="form-control" name="time"
                                            id="timepicker" value="{{ ucwords($tim[0]) }}"
                                            aria-describedby="timeHelp"
                                            />
                                            @error('time')
                                            <div id="timeHelp" class="form-text text-danger" id="error_time">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="">Fee</label>
                                            <input type="text" name="fee" id="fee" class="form-control" placeholder="Fee" value="{{ ($detail->total_amount)??'' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        @php
                                        $total_time_slots = count(explode(',', $detail->time_slots));
                                        $durationperslot = 30;
                                        $total_duration = $total_time_slots * $durationperslot;
                                        @endphp
                                        <div class="form-group">
                                            <label for="">Duration</label>
                                            <input type="text" name="duration" id="duration" class="form-control" placeholder="duration" value="{{ $total_duration }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <h5>Techniques Used</h5>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_1" value="STATIC CONTACT">
                                                    <label class="form-check-label" for="techniques_1">
                                                    STATIC CONTACT
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_2" value="STROKING">
                                                    <label class="form-check-label" for="techniques_2">STROKING</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_3" value="VIBRATION">
                                                    <label class="form-check-label" for="techniques_3">VIBRATION</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_4" value="ROCKING">
                                                    <label class="form-check-label" for="techniques_4">ROCKING</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_5" value="FASCIAL">
                                                    <label class="form-check-label" for="techniques_5">FASCIAL</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_6" value="EFFLEURAGE">
                                                    <label class="form-check-label" for="techniques_6">EFFLEURAGE</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_7" value="PETRISSAGE">
                                                    <label class="form-check-label" for="techniques_7">PETRISSAGE</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_8" value="TAPOTEMENT">
                                                    <label class="form-check-label" for="techniques_8">TAPOTEMENT</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_9" value="TRIGGER POINT THERAPY">
                                                    <label class="form-check-label" for="techniques_9">TRIGGER POINT THERAPY</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_10" value="FRICTION">
                                                    <label class="form-check-label" for="techniques_10">FRICTION</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_11" value="PASSIVE STRETCH">
                                                    <label class="form-check-label" for="techniques_11">PASSIVE STRETCH</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_12" value="FACILITATED STRETCH:">
                                                    <label class="form-check-label" for="techniques_12">FACILITATED STRETCH:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label" for="fac_str">Type:</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="text" name="fac_str" id="fac_str" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                               <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_13" value="JOINT MOBILIZATION:">
                                                    <label class="form-check-label" for="techniques_13">JOINT MOBILIZATION:</label>
                                                </div> 
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label" for="grade">Grade:</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="text" name="grade" id="grade" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                               <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_14" value="PASSIVE ROM">
                                                    <label class="form-check-label" for="techniques_14">PASSIVE ROM</label>
                                                </div> 
                                            </div>
                                            <div class="col-md-6 pt-2">
                                               <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_15" value="ACTIVE RESISTED ROM">
                                                    <label class="form-check-label" for="techniques_15">ACTIVE RESISTED ROM</label>
                                                </div> 
                                            </div>
                                            <div class="col-md-6 pt-2">
                                               <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_16" value="INTRA-ORAL WORK">
                                                    <label class="form-check-label" for="techniques_16">INTRA-ORAL WORK</label>
                                                </div> 
                                            </div>
                                            <div class="col-md-6 pt-2">
                                               <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_17" value="BREAST MASSAGE">
                                                    <label class="form-check-label" for="techniques_17">BREAST MASSAGE</label>
                                                </div> 
                                            </div>
                                            <div class="col-md-6 pt-2">
                                               <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_18" value="HYDROTHERAPY">
                                                    <label class="form-check-label" for="techniques_18">HYDROTHERAPY</label>
                                                </div> 
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label" for="grade">Type:</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="text" name="hydro_type" id="hydro_type" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                               <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="techniques[]" id="techniques_19" value="OTHER">
                                                    <label class="form-check-label" for="techniques_19">OTHER</label>
                                                </div> 
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label" for="grade">Type:</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="text" name="other_type" id="other_type" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <h5>Area's Treated</h5>
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="area_treated[]" id="area_treated_1" value="POSTERIOR THORAX">
                                                    <label class="form-check-label" for="area_treated_1">POSTERIOR THORAX</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="area_treated[]" id="area_treated_2" value="ANTERIOR THORAX">
                                                    <label class="form-check-label" for="area_treated_2">ANTERIOR THORAX</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="area_treated[]" id="area_treated_3" value="CERVICAL">
                                                    <label class="form-check-label" for="area_treated_3">CERVICAL</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="area_treated[]" id="area_treated_4" value="SHOULDERS">
                                                    <label class="form-check-label" for="area_treated_4">SHOULDERS</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="area_treated[]" id="area_treated_5" value="FACE">
                                                    <label class="form-check-label" for="area_treated_5">FACE</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="area_treated[]" id="area_treated_6" value="SCALP">
                                                    <label class="form-check-label" for="area_treated_6">SCALP</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="area_treated[]" id="area_treated_7" value="ARM/HAND L R">
                                                    <label class="form-check-label" for="area_treated_7">ARM/HAND L R</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="area_treated[]" id="area_treated_8" value="LEG/FOOT L R">
                                                    <label class="form-check-label" for="area_treated_8">LEG/FOOT L R</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="area_treated[]" id="area_treated_9" value="GLUTEALS">
                                                    <label class="form-check-label" for="area_treated_9">GLUTEALS</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="area_treated[]" id="area_treated_10" value="ABDOMINALS">
                                                    <label class="form-check-label" for="area_treated_10">ABDOMINALS</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="area_treated[]" id="area_treated_11" value="BREASTS">
                                                    <label class="form-check-label" for="area_treated_11">BREASTS</label>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="area_treated_other" id="area_treated_11" value="" placeholder="Others">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <h5>Treatment Notes</h5>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="treatment_notes[]" id="treatment_notes_1" value="<strong>A1 </strong>PT experiencing HT upper shoulder gridle &amp; suboccipital. Tight and tensed paraspinals &amp; QL. Also feeling tenderness around the PSIS BL &amp; P in QL.">
                                            <label class="form-check-label" for="treatment_notes_1"><strong>A1 </strong>PT experiencing HT upper shoulder gridle &amp; suboccipital. Tight and tensed paraspinals &amp; QL. Also feeling tenderness around the PSIS BL &amp; P in QL.</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="treatment_notes[]" id="treatment_notes_2" value="<strong>A2 </strong>PT experiencing HT cervical, shoulder and rhomboids due to nature of their job. Tight and tensed paraspinals &amp; QL. Also feeling tenderness in calf muscles, stiffness in quads">
                                            <label class="form-check-label" for="treatment_notes_2"><strong>A2 </strong>PT experiencing HT cervical, shoulder and rhomboids due to nature of their job. Tight and tensed paraspinals &amp; QL. Also feeling tenderness in calf muscles, stiffness in quads</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="treatment_notes[]" id="treatment_notes_3" value="<strong>A3 </strong>PT experiencing HT cervical, shoulder gridle &amp; arms, stiffness in flexor and extensors. Also feeling tenderness around the PSIS BL &amp; P in QL">
                                            <label class="form-check-label" for="treatment_notes_3"><strong>A3 </strong>PT experiencing HT cervical, shoulder gridle &amp; arms, stiffness in flexor and extensors. Also feeling tenderness around the PSIS BL &amp; P in QL</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="treatment_notes[]" id="treatment_notes_4" value="<strong>A4 </strong>PT experiencing HT lumber region, tenderness around the PSIS BL &amp; P in QL. Stiffness in mid back of paraspinal. Also experiencing tensed and tight leg muscles, especially calf">
                                            <label class="form-check-label" for="treatment_notes_4"><strong>A4 </strong>PT experiencing HT lumber region, tenderness around the PSIS BL &amp; P in QL. Stiffness in mid back of paraspinal. Also experiencing tensed and tight leg muscles, especially calf</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="treatment_notes[]" id="treatment_notes_5" value="<strong>A5 </strong>PT feeling improved muscle tone, &#8595; P, &#8593; ROM. TX relaxation massage focused on cervical">
                                            <label class="form-check-label" for="treatment_notes_5"><strong>A5 </strong>PT feeling improved muscle tone, &#8595; P, &#8593; ROM. TX relaxation massage focused on cervical</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="treatment_notes[]" id="treatment_notes_6" value="<strong>A6 </strong>PT feeling improved muscle tone, &#8595; P, &#8593; ROM. TX relaxation massage focused on lower back">
                                            <label class="form-check-label" for="treatment_notes_6"><strong>A6 </strong>PT feeling improved muscle tone, &#8595; P, &#8593; ROM. TX relaxation massage focused on lower back</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="treatment_notes[]" id="treatment_notes_7" value="<strong>A7 </strong>PT experiencing same symptoms as reported in the previous visit.">
                                            <label class="form-check-label" for="treatment_notes_7"><strong>A7 </strong>PT experiencing same symptoms as reported in the previous visit.</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="treatment_notes[]" id="treatment_notes_8" value="<strong>A8 </strong>PT experiencing stiffness throughout their body due to hectic daily routine. Requested relaxation MT to relieve tension.">
                                            <label class="form-check-label" for="treatment_notes_8"><strong>A8 </strong>PT experiencing stiffness throughout their body due to hectic daily routine. Requested relaxation MT to relieve tension.</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="treatment_notes[]" id="treatment_notes_9" value="1">
                                            <label class="form-check-label" for="treatment_notes_9"><strong>A9 </strong></label>
                                            <div style="margin-left: 30px; margin-top: -18px;">
												<textarea name="treat_note_9" id="treat_note_9" class="form-control" rows="2" readonly="readonly"></textarea>
											</div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Client Reaction/ Feedback To TX</h5>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="client_reaction[]" id="client_reaction_1" value="<strong>B1 </strong>Felt better, rebooked">
                                            <label class="form-check-label" for="client_reaction_1"><strong>B1 </strong>Felt better, rebooked</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="client_reaction[]" id="client_reaction_2" value="<strong>B2 </strong>Felt better and relaxed">
                                            <label class="form-check-label" for="client_reaction_2"><strong>B2 </strong>Felt better and relaxed</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="client_reaction[]" id="client_reaction_3" value="<strong>B3 </strong>Relaxed, relief from tension.">
                                            <label class="form-check-label" for="client_reaction_3"><strong>B3 </strong>Relaxed, relief from tension.</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="client_reaction[]" id="client_reaction_4" value="1">
                                            <label class="form-check-label" for="client_reaction_4"><strong>B4 </strong></label>
                                            <div style="margin-left: 30px; margin-top: -18px;"><textarea name="clt_reaction_4" id="clt_reaction_4" class="form-control" readonly rows="2"></textarea></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <h5>Home Exercises & Self Care Tx Recommended</h5>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="home_exercises[]" id="home_exercises_1" value="<strong>C1 </strong>Stretches for traps, scalene and SCM, stretches for QL">
                                            <label class="form-check-label" for="home_exercises_1"><strong>C1 </strong>Stretches for traps, scalene and SCM, stretches for QL</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="home_exercises[]" id="home_exercises_2" value="<strong>C2 </strong>Stretches for scalene, traps &amp; calf, strengthening exercise for rhomboids &amp; quads">
                                            <label class="form-check-label" for="home_exercises_2"><strong>C2 </strong>Stretches for scalene, traps &amp; calf, strengthening exercise for rhomboids &amp; quads</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="home_exercises[]" id="home_exercises_3" value="<strong>C3 </strong>Stretches for traps, flexors, and extensors">
                                            <label class="form-check-label" for="home_exercises_3"><strong>C3 </strong>Stretches for traps, flexors, and extensors</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="home_exercises[]" id="home_exercises_4" value="<strong>C4 </strong>Continue with previously recommended stretches">
                                            <label class="form-check-label" for="home_exercises_4"><strong>C4 </strong>Continue with previously recommended stretches</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="home_exercises[]" id="home_exercises_5" value="1">
                                            <label class="form-check-label" for="home_exercises_5"><strong>C4 </strong></label>
                                            <div style="margin-left: 30px; margin-top: -18px;"><textarea name="hom_exercises_5" id="hom_exercises_5" class="form-control" readonly="" rows="2"></textarea></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    {{--end::Footer--}}
                  </form>
                  {{--end::Form--}}
                </div>
            </div>
        </div>
    {{--end::Row--}}

    </div>
    {{--end::Container--}}
</div>
@endsection