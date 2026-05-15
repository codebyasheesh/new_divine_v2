@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">SMTP Settings</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">SMTP Settings</li>
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
                  <form action="{{ route('admin.update.smtp') }}" method="post">
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
                                        <div class="form-group mb-3">
                                            <label for="mail_host" class="form-label fw-bold">Mail Host:</label>
                                            <input type="text" name="mail_host" id="mail_host" class="form-control" value="{{ $data->mail_host ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <div class="form-group mb-3">
                                            <label for="mail_port" class="form-label fw-bold">Mail Port:</label>
                                            <input type="text" name="mail_port" id="mail_port" class="form-control" value="{{ $data->mail_port ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <div class="form-group mb-3">
                                            <label for="mail_encryption" class="form-label fw-bold">Mail Encryption:</label>
                                            <input type="text" name="mail_encryption" id="mail_encryption" class="form-control" value="{{ $data->mail_encryption ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group mb-3">
                                            <label for="mail_username" class="form-label fw-bold">Mail Username:</label>
                                            <input type="text" name="mail_username" id="mail_username" class="form-control" value="{{ $data->mail_username ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group mb-3">
                                            <label for="mail_password" class="form-label fw-bold">Mail Password:</label>
                                            <input type="text" name="mail_password" id="mail_password" class="form-control" value="{{ $data->mail_password ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group mb-3">
                                            <label for="mail_from_address" class="form-label fw-bold">Mail From Address:</label>
                                            <input type="text" name="mail_from_address" id="mail_from_address" class="form-control" value="{{ $data->mail_from_address ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group mb-3">
                                            <label for="mail_from_name" class="form-label fw-bold">Mail From Name:</label>
                                            <input type="text" name="mail_from_name" id="mail_from_name" class="form-control" value="{{ $data->mail_from_name ?? '' }}">
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