@extends('admin.layouts.app')

@section('content')
<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Soap Notes</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Soap Notes List</li>
        </ol>
        </div>
    </div>
    {{--end::Row--}}
    </div>
    {{--end::Container--}}
</div>
{{--end::App Content Header--}}
{{--begin::App Content--}}
<div class="app-content">
    {{--begin::Container--}}
    <div class="container-fluid">
    {{--begin::Row--}}
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        {{-- <h3 class="card-title">Services</h3> --}}
                        {{-- <div class="d-flex justify-content-start">
                            <a href="{{route('admin.generate_soapnote')}}" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Generate SOAP Note"
                        role="button"><i class="bi bi-plus-circle"></i> Generate SOAP Note</a>
                        </div> --}}
                    </div>
                    {{-- /.card-header --}}
                    <div class="card-body">
                    <table class="table table-striped table-sm" id="soapnote-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>File Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($pdfs as $val)
                                @php
                                $delete = "deleteSoapNote('".$val['name']."')";
                                @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $val['name'] }}</td>
                                <td>
                                    <a href="{{route('admin.download_soap', $val['name'])}}" class="btn btn-primary btn-sm" data-bs-toggletip="tooltip" data-bs-title="Download SOAP Note"><i class="bi bi-download"></i> SOAP Notes</a>
                                    <a href="javascript:void(0);" onclick="{{$delete}}" class="btn btn-danger btn-sm" data-bs-toggletip="tooltip" data-bs-title="Delete SOAP Note"><i class="bi bi-trash"></i> Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    {{-- /.card-body --}}
                </div>
            </div>
        </div>
    {{--end::Row--}}

    </div>
    {{--end::Container--}}
</div>
@endsection