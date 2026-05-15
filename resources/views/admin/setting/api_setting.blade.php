@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">API Settings</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">API Settings</li>
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
                  <form action="{{ route('admin.update_setting') }}" method="post">
                    @csrf
                    {{--begin::Header--}}
                    <input type="hidden" name="id" value="{{$data->id}}">
                    {{--end::Footer--}}
                    <div class="card card-info card-outline mb-4">
                        <div class="card-header"><div class="card-title fw-bold">Settings</div></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="row">
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