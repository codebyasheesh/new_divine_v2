@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Sales Tax Report</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sales Tax</li>
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
                <div class="card card-info card-outline mb-4">
                {{--begin::Header--}}
                    {{-- <div class="card-header">
                        <div class="card-title fw-bold">Customer Statement according to Date Range:</div>
                    </div> --}}
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Date Range</label>
                                        <div class="input-daterange input-group" id="datepicker">
                                            <input type="text" class="input-sm form-control" name="tax_start_dt" />
                                            <span class="input-group-addon" style="min-width: 16px; padding: 6px 10px; line-height: 1.42857143; border-width: 1px 0; background-color:#f5f2f2">to</span>
                                            <input type="text" class="input-sm form-control" name="tax_end_dt" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div style="padding-top:2.0rem;">
                                        <button type="button" class="btn btn-primary" id="btnSalesTaxSearch">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--end::Footer--}}
            </div>
            <div class="col-12">
                <div class="card card-info card-outline mb-4">
                    <div class="card-header">
                        <div class="card-title fw-bold">Sales Tax:</div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-4">
                            <div class="col-12">
                                <table class="table table-striped table-sm" id="sales_tax_tbl">
                                    <thead>
                                        <tr>
                                            <td style="border: none; font-weight: bold;">Tax</td>
                                            <td style="width: 60%; border: none;">&nbsp;</td>
                                            <td style="border: none; font-weight: bold;" class="text-end">
                                                <div class="tx_dt_rng"></div>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $setting = getSetting();
                                        @endphp
                                        <tr>
                                            <td>{{$setting->tax_name.' '.$setting->tax_value}}% Tax</td>
                                            <td style="width: 50%;">&nbsp;</td>
                                            <td class="text-end"><div id="tax_val"></div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card-footer text-end">
                        <button type="button" class="btn btn-primary"><i class="bi bi-envelope-arrow-up"></i> Send Statement</button>
                        <button type="button" class="btn btn-primary" id="btnDownloadCustomerStatment"><i class="bi bi-download"></i> Download Statement</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    {{--end::Row--}}

    </div>
    {{--end::Container--}}
</div>
@endsection