@extends('admin.layouts.app')

@section('content')
<div class="app-content-header">
          {{-- begin::Container --}}
    <div class="container-fluid">
    {{--begin::Row--}}
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Invoices</h3></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Invoices</li>
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
                        <div class="row">
                            <div class="col-3">
                                <a href="{{ route('admin.new_invoice') }}" class="btn btn-sm btn-primary" data-bs-toggletip="tooltip" data-bs-title="Add Invoice" role="button"><i class="bi bi-plus-circle"></i> Add</a>
                            </div>
                            <div class="col-3 text-end mt-1">
                                <label class="form-label fw-bold">Date Range:</label>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="input-sm form-control" placeholder="From" id="inv_st" />
                                        <span class="input-group-addon" style="min-width: 16px; padding: 6px 10px; line-height: 1.42857143; border-width: 1px 0; background-color:#f5f2f2">to</span>
                                        <input type="text" class="input-sm form-control" placeholder="to" id="inv_ed" />
                                        <button class="btn btn-sm btn-primary" id="invDateFilter" data-bs-toggletip="tooltip" data-bs-title="Date Range Filter" role="button"><i class="bi bi-search"></i> Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start">
                            
                        </div>
                    </div>
                    {{-- /.card-header --}}
                    <div class="card-body">
                    <table class="table table-striped table-sm" id="invoice-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Status</th>
                            <th>Inv. Sent</th>
                            <th>Inv. Date</th>
                            <th>Invoice</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Amount Due</th>
                            <th>Action</th>
                        </tr>
                        </thead>
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

<!-- Email Statement Modal -->
<div class="modal fade" id="sendInvoiceMailModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Send Mail to Client</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <input type="hidden" id="invoice_id">
                    <div class="form-check-inline">
                        <input class="form-check-input" type="checkbox" id="default_inv_mail" value="" checked>
                        <label class="form-check-label" id="default_lbl_email">
                        </label>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <div class="form-group">
                        <label for="other_mailid">Other Mail Id</label>
                        <input type="email" id="other_inv_email" class="form-control" value="">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="btnSendInvoiceMail" class="btn btn-primary">Send</button>
            <button class="btn btn-primary d-none" id="loader" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Sending...
            </button>
        </div>
        </div>
    </div>
</div>
@endsection