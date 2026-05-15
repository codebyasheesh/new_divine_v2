@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">System Settings</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">System Settings</li>
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
                  <form action="{{ route('admin.update.system.settings') }}" method="post">
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
                                        <label class="form-label fw-bold">Global SMS On/Off</label>
                                        <div class="form-group mt-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="global_sms" id="sms_on" {{ ($data->global_sms == 1)?'checked':'' }} value="1">
                                                <label class="form-check-label" for="sms_on"><strong>On</strong></label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="global_sms" id="sms_off" {{ ($data->global_sms == 0)?'checked':'' }} value="0">
                                                <label class="form-check-label" for="sms_off"><strong>Off</strong></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-4">
                                        <label class="form-label fw-bold">Payment On/Off</label>
                                        <div class="form-group mt-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="online_payment" id="online_payment_1" {{ ($data->online_payment == 1)?'checked':'' }} value="1">
                                                <label class="form-check-label" for="online_payment_1"><strong>On</strong></label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="online_payment" id="online_payment_2" {{ ($data->online_payment == 0)?'checked':'' }} value="0">
                                                <label class="form-check-label" for="online_payment_2"><strong>Off</strong></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <label class="form-label fw-bold">Google Captcha On/Off</label>
                                        <div class="form-group mt-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="googlecaptcha" id="googlecaptcha_1" {{ ($data->googlecaptcha == 1)?'checked':'' }} value="1">
                                                <label class="form-check-label" for="googlecaptcha_1"><strong>On</strong></label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="googlecaptcha" id="googlecaptcha_2" {{ ($data->googlecaptcha == 0)?'checked':'' }} value="0">
                                                <label class="form-check-label" for="googlecaptcha_2"><strong>Off</strong></label>
                                            </div>
                                        </div>
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