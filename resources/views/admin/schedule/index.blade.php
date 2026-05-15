@extends('admin.layouts.app')

@section('content')
<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Time Slot By Day</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Schedules</li>
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
                            <div class="d-flex justify-content-start">
                                <a href="{{ route('admin.add_schedule') }}" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Add Schedule" role="button"><i class="bi bi-plus-circle"></i> Add or Edit </a>
                            </div>
                        {{-- <div class="d-flex justify-content-end">
                            
                        </div> --}}
                    </div>
                    {{-- /.card-header --}}
                    <div class="card-body">
                    <table class="table table-striped table-sm" id="schedule-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Day</th>
                            <th>Blocked Times</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $val)
                            @php
                                $deleteDayTimeSchedule = "deleteDayTimeSchedule('".$val->id."')";
                                $expld = explode(",", $val->block_time);
                                $blk_tm = '';

                            @endphp
                            @foreach($expld as $blktm) 
                            @php
                            $blk_tm .= $blktm.', ';
                            
                            @endphp
                            @endforeach
                            @php
                            $blk_tm = rtrim($blk_tm, ", ");
                            @endphp
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $val->day }}</td>
                                <td style="word-wrap: break-word; width: 60%;"><div>{{ ($val->block_time)?$blk_tm:'All Time Available' }}</div></td>
                                <td>
                                    <a href="{{route('admin.daytime.edit', $val->id)}}" class="btn btn-primary btn-sm me-2"><i class="bi bi-pencil"></i> Edit</a>
                                    <a href="javascript:void(0);" onclick="{{$deleteDayTimeSchedule}}" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</a>
                                </td>
                                {{-- {{route('admin.deletedaytime', $val->id)}} --}}
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">Record Not Found</td>
                            </tr>
                            @endforelse
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