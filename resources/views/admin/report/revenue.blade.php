@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Revenue Statement</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Revenue Statement</li>
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
                                            <input type="text" class="input-sm form-control" name="start_dt" />
                                            <span class="input-group-addon" style="min-width: 16px; padding: 6px 10px; line-height: 1.42857143; border-width: 1px 0; background-color:#f5f2f2">to</span>
                                            <input type="text" class="input-sm form-control" name="end_dt" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div style="padding-top:2.0rem;">
                                        <button type="button" class="btn btn-primary" id="btnProLosSearch">Submit</button>
                                        <button class="btn btn-primary d-none" id="loader" type="button" disabled>
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Loading...
                                        </button>
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
                        <div class="card-title fw-bold">Revenue:</div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-4">
                            <div class="col-12">
                                <table class="table table-striped table-sm" id="customer_report_tbl">
                                    <thead>
                                        <tr>
                                            <td style="border: none; font-weight: bold;">Accounts</td>
                                            <td style="width: 60%; border: none; font-weight: bold;"><div class="dt_rng"></div></td>
                                            <td style="border: none;">&nbsp;</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="3"><strong>Invoiced Total</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Total Billed (Invoiced Amount incl. Tax)</td>
                                            <td style="width: 50%;">&nbsp;</td>
                                            <td class="text-end"><div id="billed_val"></div></td>
                                        </tr>
                                        <tr>
                                            <td>Tax (Invoiced Tax Amount)</td>
                                            <td style="width: 50%;">&nbsp;</td>
                                            <td class="text-end"><div id="tax_val"></div></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><strong>Recorded / Pending A</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Direct Billing</td>
                                            <td style="width: 50%;">&nbsp;</td>
                                            <td class="text-end"><div id="direct_amt" class="fw-bold"></div></td>
                                        </tr>
                                        <tr>
                                            <td>Bank Payment</td>
                                            <td style="width: 50%;">&nbsp;</td>
                                            <td class="text-end"><div id="bank_amt" class="fw-bold"></div></td>
                                        </tr>
                                        <tr>
                                            <td>Cash Payment</td>
                                            <td style="width: 50%;">&nbsp;</td>
                                            <td class="text-end"><div id="cash_amt" class="fw-bold"></div></td>
                                        </tr>
                                        <tr>
                                            <td>Account Payment</td>
                                            <td style="width: 50%;">&nbsp;</td>
                                            <td class="text-end"><div id="account_amt" class="fw-bold"></div></td>
                                        </tr>
                                        <tr>
                                            <td>Other Payments</td>
                                            <td style="width: 50%;">&nbsp;</td>
                                            <td class="text-end"><div id="other_amt" class="fw-bold"></div></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Recorded Amount</strong></td>
                                            <td style="width: 40%;">&nbsp;</td>
                                            <td class="text-end"><div id="recod_amt" class="fw-bold"></div></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Received Amount (Recorded Amount w/o Account Payment)*</strong></td>
                                            <td style="width: 40%;">&nbsp;</td>
                                            <td class="text-end"><div id="received_amt" class="fw-bold"></div></td>
                                        </tr>
                                        {{-- <tr>
                                            <td><strong>Credit Amount (Received - Tax)</strong></td>
                                            <td style="width: 50%;">&nbsp;</td>
                                            <td class="text-end"><div id="credit_amt" class="fw-bold"></div></td>
                                        </tr> --}}
                                        <tr>
                                            <td><strong>Pending Amount (Includes Partial Pending Amount)</strong></td>
                                            <td style="width: 50%;">&nbsp;</td>
                                            <td class="text-end"><div id="pending_amt" class="fw-bold"></div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        {{-- <button type="button" class="btn btn-primary"><i class="bi bi-printer"></i> Print</button> --}}
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-download"></i> Download Statement
                            </button>
                            <ul class="dropdown-menu">
                                <li><button class="dropdown-item" id="btnDownloadRevenuePdf"><i class="bi bi-file-earmark-pdf"></i> PDF Format</button></li>
                                <li><button class="dropdown-item" id="btnDownloadRevenueExcel"><i class="bi bi-file-earmark-spreadsheet"></i> Excel Format</button></li>
                            </ul>
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