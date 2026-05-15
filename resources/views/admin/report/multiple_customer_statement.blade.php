@extends('admin.layouts.app')

@section('content')

<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Multiple Customer Statement</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Multiple Customer Report</li>
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
                    <div class="card-header">
                        <div class="card-title fw-bold">Search:</div>
                    </div>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Payment Options</label>
                                        <div>
                                            <div class="form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="direct_billing" value="Direct Billing">
                                                <label class="form-check-label" for="direct_billing">
                                                    Direct Billing
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="bank_payment" value="Bank Payment">
                                                <label class="form-check-label" for="bank_payment">
                                                    Bank Payment
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="cash" value="Cash">
                                                <label class="form-check-label" for="cash">
                                                    Cash
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="other_method" value="Other Method">
                                                <label class="form-check-label" for="other_method">
                                                    Other Method
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="account" value="Account">
                                                <label class="form-check-label" for="account">
                                                    Account
                                                </label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mt-3">
                                    <div id="customer_fields">
                                        <div class="form-group customer-field">
                                            <label for="final_amount" class="form-label fw-bold">Customer Name: <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-person"></i></span>
                                                <input type="text" class="form-control customer-input" id="customer_search" value="" placeholder="Enter name or mobile" aria-describedby="customer_idHelp"
                                                />
                                            </div>
                                            <div id="customer_suggestions" class="list-group"></div>
                                            <input type="hidden" name="customer_id" value="">
                                            <input type="hidden" name="customer_mobile" value="">
                                            <input type="hidden" name="customer_email" value="">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6 mt-3">
                                    <button name="addField" id="addField" type="button" class="btn btn-primary btn-sm" style="margin-top: 2.2rem;">Add More</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" id="btnSearchMultiCustStatement">Submit</button>
                    </div>
                </div>
                {{--end::Footer--}}
            </div>
            <div class="col-12">
                <div class="card card-success card-outline mb-4">
                    <div class="card-header">
                        <div class="card-title fw-bold">Report:</div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-4">
                            <div class="col-12">
                                <table class="table table-striped table-sm" id="customer_report_tbl">
                                    <thead>
                                        <tr>
                                            <th>Invoice date</th>
                                            <th>Invoice No.</th>
                                            <th>Name</th>
                                            {{-- <th>Services</th>
                                            <th>Prices</th> --}}
                                            <th>Tax</th>
                                            <th>Invoice Amount</th>
                                            <th>Received Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="mcustomer_report">
                                        
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-primary" id="btnPrintMultipleStatement"><i class="bi bi-printer"></i> Print</button>
                        {{-- <button type="button" class="btn btn-primary" id="btnEmailMultipleCustomerStatement"><i class="bi bi-envelope-arrow-up"></i> Send Statement</button> --}}
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#multipleMailModal" data-bs-whatever="multipleMailModal" id="btnSendMultipleMail"><i class="bi bi-envelope-arrow-up"></i> Send Statement</button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-download"></i> Download Statement
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    {{-- <button type="button" class="btn btn-primary" id="btnDownloadMultipleCustomerStatment"><i class="bi bi-download"></i> Download Statement</button> --}}
                                    <button class="dropdown-item" onclick="multipleCustomerReportDownload('pdf');"><i class="bi bi-file-earmark-pdf"></i> PDF Format</button>
                                </li>
                                <li><button class="dropdown-item" id="btnMultipleExcelDownload" onclick="multipleCustomerReportDownload('xlsx');"><i class="bi bi-file-earmark-spreadsheet"></i> Excel Format</button></li>
                            </ul>
                        </div>
                        {{-- <button type="button" class="btn btn-primary" id="btnDownloadMultipleCustomerStatment"><i class="bi bi-download"></i> Download Statement</button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--end::Row--}}

    </div>
    {{--end::Container--}}
</div>

<!-- Multiple User Email Statement Modal -->
    <div class="modal fade" id="multipleMailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Send Mail to Customer</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-check-inline">
                            <input class="form-check-input" type="checkbox" id="default_mail" value="" checked>
                            <label class="form-check-label" id="default_lbl_email">
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check-inline" id="eml_1">
                            <input class="form-check-input" type="checkbox" id="default_mail_1" value="" checked>
                            <label class="form-check-label" id="default_lbl_email_1">
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check-inline" id="eml_2">
                            <input class="form-check-input" type="checkbox" id="default_mail_2" value="" checked>
                            <label class="form-check-label" id="default_lbl_email_2">
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check-inline" id="eml_3">
                            <input class="form-check-input" type="checkbox" id="default_mail_3" value="" checked>
                            <label class="form-check-label" id="default_lbl_email_3">
                            </label>
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="form-group">
                            <label>Other Mail Id</label>
                            <input type="email" id="other_single_email_m" class="form-control" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnEmailMultipleCustomerStatement" class="btn btn-primary">Send</button>
                <button class="btn btn-primary d-none" id="loader" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Sending...
                </button>
            </div>
            </div>
        </div>
    </div>
@endsection