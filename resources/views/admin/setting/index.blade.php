@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Settings</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Settings</li>
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
                  <form action="{{ route('admin.update_setting') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{--begin::Header--}}
                    <input type="hidden" name="id" value="{{$data->id}}">
                    {{--end::Footer--}}
                    <div class="card card-info card-outline mb-4">
                        <div class="card-header"><div class="card-title fw-bold">Settings</div></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">HST Registration No.</label>
                                            <input type="text" name="hst_registration_no" id="hst_registration_no" class="form-control" value="{{$data->hst_registration_no}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <label class="form-label fw-bold">Global Mail On/Off</label>
                                        <div class="form-group mt-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="global_mail" id="on" {{ ($data->global_mail == 1)?'checked':'' }} value="1">
                                                <label class="form-check-label" for="on"><strong>On</strong></label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="global_mail" id="off" {{ ($data->global_mail == 0)?'checked':'' }} value="0">
                                                <label class="form-check-label" for="off"><strong>Off</strong></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-4">
                                        <label class="form-label fw-bold">Service Duration</label>
                                        <div class="form-group mt-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="duration" id="duration_1" {{ ($data->duration == 30)?'checked':'' }} value="30">
                                                <label class="form-check-label" for="duration_1"><strong>30 Mins</strong></label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="duration" id="duration_2" {{ ($data->duration == 60)?'checked':'' }} value="60">
                                                <label class="form-check-label" for="duration_2"><strong>60 Mins</strong></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-4">
                                        <label class="form-label fw-bold">Start Time</label>
                                        <div class="form-group">
                                           <input type="time" name="start_time" id="start_time" class="form-control" value="{{ $data->start_time }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <label class="form-label fw-bold">End Time</label>
                                        <div class="form-group">
                                            <input type="time" name="end_time" id="end_time" class="form-control" value="{{ $data->end_time }}">
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="tax_name" class="form-label fw-bold">Tax Name:</label>
                                            <input
                                            type="text"
                                            class="form-control" name="tax_name"
                                            id="tax_name" value="{{ $data->tax_name }}" aria-describedby="tax_nameHelp" />
                                            
                                            @error('tax_name')
                                            <div id="tax_nameHelp" class="form-text text-danger" id="error_tax_name">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="tax_value" class="form-label fw-bold">Tax Value(%):</label>
                                            <input
                                            type="text"
                                            class="form-control" name="tax_value"
                                            id="tax_value" value="{{ $data->tax_value }}" aria-describedby="tax_valueHelp" />
                                            
                                            @error('tax_value')
                                            <div id="tax_valueHelp" class="form-text text-danger" id="error_tax_value">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="notes" class="form-label fw-bold">Notes:</label>
                                            <input
                                            type="text"
                                            class="form-control" name="notes"
                                            id="notes" value="{{ old('notes')??$data->notes }}"
                                            aria-describedby="notesHelp"
                                            />
                                            @error('notes')
                                            <div id="notesHelp" class="form-text text-danger" id="error_notes">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="terms" class="form-label fw-bold">Terms:</label>
                                            <input type="text" class="form-control" name="terms" id="terms" value="{{ old('terms')??$data->terms }}" aria-describedby="termsHelp" />
                                            @error('terms')
                                            <div id="termsHelp" class="form-text text-danger" id="error_terms">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <fieldset class="border p-3">
                                            <legend class="float-none w-auto px-2">Square Payment Setting</legend>
                                            <div class="mb-3">
                                                <label for="application_id" class="form-label fw-bold">Application ID</label>
                                                <input type="text" name="application_id" id="application_id" class="form-control" value="{{ $data->square_application_id ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="access_token" class="form-label fw-bold">Access Token</label>
                                                <input type="text" name="access_token" id="access_token" class="form-control" value="{{ $data->square_access_token ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="square_location_id" class="form-label fw-bold">Location ID</label>
                                                <input type="text" name="square_location_id" id="square_location_id" class="form-control" value="{{ $data->square_location_id ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="square_environment" class="form-label fw-bold">Environment</label>
                                                <input type="text" name="square_environment" id="square_environment" class="form-control" value="{{ $data->square_environment ?? '' }}">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <fieldset class="border p-3">
                                            <legend class="float-none w-auto px-2">SMS API Setting</legend>
                                            <div class="mb-3">
                                                <label for="twilio_sid" class="form-label fw-bold">Twilio SID</label>
                                                <input type="text" name="twilio_sid" id="twilio_sid" class="form-control" value="{{ $data->twilio_sid ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="twilio_auth_token" class="form-label fw-bold">Twilio Auth Token</label>
                                                <input type="text" name="twilio_auth_token" id="twilio_auth_token" class="form-control" value="{{ $data->twilio_auth_token ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="twilio_from" class="form-label fw-bold">Twilio From</label>
                                                <input type="text" name="twilio_from" id="twilio_from" class="form-control" value="{{ $data->twilio_from ?? '' }}">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <fieldset class="border p-3">
                                            <legend class="float-none w-auto px-2">Google Captcha Key</legend>
                                            <div class="mb-3">
                                                <label for="site_key" class="form-label fw-bold">Site Key</label>
                                                <input type="text" name="site_key" id="site_key" class="form-control" value="{{ $data->google_captcha_sitekey }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="secret_key" class="form-label fw-bold">Secret Key</label>
                                                <input type="text" name="secret_key" id="secret_key" class="form-control" value="{{ $data->google_captcha_secretkey }}">
                                            </div>
                                        </fieldset>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    {{--end::Row--}}

    </div>
    {{--end::Container--}}
</div>
@endsection