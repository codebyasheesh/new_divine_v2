@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Edit Sms Template</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.sms.templates') }}">Email Templates</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Template</li>
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
                  {{--begin::Form--}}
                <form action="{{ route('admin.update.sms.template') }}" method="post">
                @csrf
                <div class="card card-info card-outline mb-4">
                    {{--begin::Header--}}
                    <div class="card-header">
                        <div class="card-title fw-bold">Sms Template</div>
                        <input type="hidden" name="id" value="{{ $data->id }}">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Template Name</label>
                                    <div class="input-group">
                                        <input type="text" name="template_name" id="template_name" class="form-control" value="{{ old('template_name', $data->template_name ?? '') }}" placeholder="Enter Template Name">
                                    </div>
                                    @error('template_name')
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Template Key</label>
                                    <div class="input-group">
                                        <input type="text" name="sms_key" id="sms_key" class="form-control" value="{{ old('sms_key', $data->sms_key ?? '') }}" placeholder="Template Key" readonly>
                                    </div>
                                    @error('sms_key')
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Body</label>
                                    <div class="input-group">
                                        <textarea name="body" id="body" class="form-control" placeholder="Enter Email Content Here.">{{ old('body', $data->body ?? '') }}</textarea>
                                    </div>
                                    @error('body')
                                    <div class="form-text text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('admin.sms.templates') }}" id="btnCancel" class="btn btn-danger ms-2">Cancel</a>
                    </div>
                </div>
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