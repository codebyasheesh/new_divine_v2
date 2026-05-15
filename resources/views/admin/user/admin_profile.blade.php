@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Admin Profile</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Admin Profile</li>
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
        <div class="row g-4 d-flex justify-content-center">
            <div class="col-md-8">
  
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
                  <form action="{{ route('admin.update_admin_profile') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{--begin::Header--}}
                    <input type="hidden" name="id" value="{{$data->id}}">
                    
                    {{--end::Footer--}}
                    <div class="card card-info card-outline mb-4">
                        <div class="card-header"><div class="card-title fw-bold">Admin Profile</div></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">First Name</label>
                                            <input type="text" name="first_name" id="first_name" class="form-control" value="{{$data->first_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Last Name</label>
                                            <input type="text" name="last_name" id="last_name" class="form-control" value="{{$data->last_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="email" class="form-label fw-bold">Email: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="email" id="email" value="{{ $data->email }}" aria-describedby="emailHelp" />
                                            @error('email')
                                            <div id="emailHelp" class="form-text text-danger" id="error_email">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="mobile" class="form-label fw-bold">Mobile: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="mobile" id="mobile" value="{{ old('mobile')??$data->mobile }}" aria-describedby="mobileHelp" />
                                            @error('mobile')
                                            <div id="mobileHelp" class="form-text text-danger" id="error_mobile">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <div class="form-group">
                                            <label for="whatsapp_no" class="form-label fw-bold">Whatsapp No: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="whatsapp_no" id="whatsapp_no" value="{{ old('whatsapp_no')??$data->whatsapp_no }}" aria-describedby="mobileHelp" maxlength="12" />
                                            @error('whatsapp_no')
                                            <div id="whatsapp_noHelp" class="form-text text-danger" id="error_whatsapp_no">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="profile_img" class="form-label fw-bold">Profile Pic </label>
                                            <input type="file" name="profile_img" id="profile_img" class="form-control" />
                                            <small><strong>Notes:</strong> Image Dimension should be: 160 x 160 px</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <div class="form-group">
                                            <img src="{{asset('admin_assets/assets/img/'.$data->profile_img)}}" class="img-fluid">
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
                  <form action="{{ route('admin.update_password') }}" method="post">
                    @csrf
                    <div class="card card-success card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title fw-bold">Change Password</div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">New Password</label>
                                            <input type="password" name="password" id="password" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Confirm Password</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="">
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