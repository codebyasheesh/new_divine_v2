@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Company Detail</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Company Detail</li>
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
                  <form id="frmCompanyDetail" action="{{ route('admin.update_company_detail') }}" method="post" enctype="multipart/form-data">
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
                                            <label class="form-label fw-bold">Company Name <span class="text-danger">*</span></label>
                                            <input type="text" name="company_name" id="company_name" class="form-control" value="{{$data->company_name}}" minlength="3">
                                            <div class="text-danger" id="err_comp_nm"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Company Phone <span class="text-danger">*</span></label>
                                            <input type="text" name="company_phone" id="company_phone" class="form-control" value="{{ $data->company_phone }}" maxlength="12">
                                            <div class="text-danger" id="err_comp_ph"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Company Email <span class="text-danger">*</span></label>
                                            <input type="text" name="company_email" id="company_email" class="form-control" value="{{ $data->company_email }}" maxlength="100">
                                            <div class="text-danger" id="err_comp_email"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Whatsapp No <span class="text-danger">*</span></label>
                                            <input type="text" name="whatsapp_no" id="whatsapp_no" class="form-control" value="{{ $data->company_whatsapp }}" maxlength="12">
                                            <div class="text-danger" id="err_whats_no"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Company Address <span class="text-danger">*</span></label>
                                            <input type="text" name="company_address" id="company_address" class="form-control" value="{{ $data->company_address }}" minlength="5">
                                            <div class="text-danger" id="err_comp_addr"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Tax Reg. Number <span class="text-danger">*</span></label>
                                            <input type="text" name="company_tax_reg_number" id="company_tax_reg_number" class="form-control" value="{{ $data->company_tax_reg_number }}" minlength="5">
                                            <div class="text-danger" id="err_reg_no"></div>
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
                                            <label class="form-label fw-bold">Tax Name <span class="text-danger">*</span></label>
                                            <input type="text" name="tax_name" id="tax_name" class="form-control" value="{{ $data->tax_name }}" minlength="5">
                                            <div class="text-danger" id="err_tax_name"></div>
                                            @error('tax_name')
                                            <div id="tax_nameHelp" class="form-text text-danger" id="error_tax_name">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="tax_value" class="form-label fw-bold">Tax Value(%) <span class="text-danger">*</span>:</label>
                                            <input type="text" class="form-control" name="tax_value" id="tax_value" value="{{ $data->tax_value }}" aria-describedby="tax_valueHelp" />
                                            <div class="text-danger" id="err_tax_value"></div>
                                            @error('tax_value')
                                            <div id="tax_valueHelp" class="form-text text-danger" id="error_tax_value">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="notes" class="form-label fw-bold">Notes:</label>
                                            <input type="text" class="form-control" name="notes" id="notes" value="{{ old('notes') ?? $data->notes }}" aria-describedby="notesHelp" />
                                            <div class="text-danger" id="err_notes"></div>
                                            @error('notes')
                                            <div id="notesHelp" class="form-text text-danger" id="error_notes">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="terms" class="form-label fw-bold">Terms:</label>
                                            <input type="text" class="form-control" name="terms" id="terms" value="{{ old('terms')??$data->terms }}" aria-describedby="termsHelp" />
                                            <div class="text-danger" id="err_terms"></div>
                                            @error('terms')
                                            <div id="termsHelp" class="form-text text-danger" id="error_terms">{{ $message }}</div>
                                            @enderror
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="profile_img" class="form-label fw-bold">Back-end Logo:</label>
                                            <input type="file" name="backend_logo" id="backend_logo" class="form-control">
                                            <small><strong>Notes:</strong> Image Dimension should be: 219 x 70 px</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group bg-dark">
                                            <img src="{{asset('admin_assets/assets/img/'.$data->backend_logo)}}" class="img-fluid">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="profile_img" class="form-label fw-bold">Front-end Logo:</label>
                                            <input type="file" name="frontend_logo" id="frontend_logo" class="form-control">
                                            <small><strong>Notes: </strong>Logo Dimension Should be: 219 x 70px</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <img src="{{asset('admin_assets/assets/img/'.$data->frontend_logo)}}" class="img-fluid">
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