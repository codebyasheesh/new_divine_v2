@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Revenue Graph</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Revenue Graph</li>
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
            <div class="col-12">
                <div class="card mb-4">
                  <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                      <h3 class="card-title">Sales</h3>
                      <a
                        href="javascript:void(0);"
                        class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                        >View Report</a
                      >
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex">
                      <p class="d-flex flex-column">
                        <span class="fw-bold fs-5">${{number_format($total_revenue, 2)}}</span> <span>Sales Over Time</span>
                      </p>
                      {{-- <p class="ms-auto d-flex flex-column text-end">
                        <span class="text-success"> <i class="bi bi-arrow-up"></i> 33.1% </span>
                        <span class="text-secondary">Since Past Year</span>
                      </p> --}}
                    </div>
                    <!-- /.d-flex -->
                    <div class="position-relative mb-4"><div id="sales-chart"></div></div>
                    <div class="d-flex flex-row justify-content-end">
                      <span class="me-2">
                        <i class="bi bi-square-fill text-primary"></i> This year
                      </span>
                      <span> <i class="bi bi-square-fill text-secondary"></i> Last year </span>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    {{--end::Row--}}

    </div>
    {{--end::Container--}}
</div>
@endsection