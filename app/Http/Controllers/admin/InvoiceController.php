<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\InvoicePaymentLink;
use App\Mail\InvoiceMail;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Service;
use App\Models\ServiceProvider;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Square\SquareClient;
use Square\Checkout\PaymentLinks\Requests\CreatePaymentLinkRequest;
use Square\Environments;
use Square\Types\Order;
use Square\Types\OrderLineItem;
use Square\Types\Money;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('admin.invoice.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $query = Invoice::with('payment');

            if($request->inv_st && $request->inv_ed) {
                $start = get_formatted_date($request->inv_st, 'Y-m-d');
                $end = get_formatted_date($request->inv_ed, 'Y-m-d');
                $query->whereBetween('invoice_date', [$start, $end]);
            }
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('status', function ($invoice) {
                    $status = $invoice->payment_status ?? '-';
                    $badges = [
                        'paid' => 'success',
                        'pending'  => 'danger',
                        'partial'   => 'warning',
                    ];
                    $color = $badges[$status] ?? 'secondary';
                    return '<div><span class="badge text-bg-' . $color . '">' . ucfirst($status) . '</span></div>';
                })
                ->addColumn('invoice_sent', function($invoice){
                    $sent_dt = $invoice->invoice_sent_date ?? '';
                    if($sent_dt) {
                        return '<div><span class="badge text-bg-success">'. get_formatted_date($sent_dt, 'M d, Y h:i A') .'</span></div>';
                    }
                    else {
                        return '<div><span class="badge text-bg-warning">Not Sent</span></div>';
                    }
                })
                ->addColumn('invoice_date', function ($invoice) {
                    return get_formatted_date($invoice->invoice_date, 'M d, Y') ?? '-';
                })
                ->addColumn('customer', function ($invoice) {
                    return '<div><a href="javascript:void(0);" data-bs-toggletip="tooltip" data-bs-title="Email: '.$invoice->customer_email.', Mobile: '.$invoice->customer_mobile.'">' . ucwords($invoice->customer_name) . '</a></div>';
                })
                ->addColumn('total', function ($invoice) {
                    return '<div>$<span>'.$invoice->final_amount.'</span></div>';
                })
                ->addColumn('amount_due', function ($invoice){
                    $total_paid = 0;
                    if($invoice->payment()->count() > 0){
                        $total_paid = $invoice->payment->paid_amount;
                    }
                    
                    $remaining_amount = number_format($invoice->final_amount - $total_paid, 2);
                    return '<div>$<span>'. $remaining_amount .'</span></div>';
                })
                ->addColumn('action', function ($invoice) {
                    // $send_invoice = route('admin.send_invoice', $invoice->id);
                    $mail_popup = "sendInvoicePopup('". $invoice->id ."')";
                    $edit_invoice = route('admin.edit_invoice', $invoice->id);
                    // $payment_lnk = route('admin.send_pay_lnk', $invoice->id);
                    $payment_lnk = "invoicePaymentLink('".$invoice->id."')";
                    $delete_invoice = "deleteInvoice('".$invoice->id."')";
                    $total_paid = 0;
                    $sendpaylnk = '';
                    if($invoice->payment()->count() > 0){
                        $total_paid = $invoice->payment->paid_amount;
                    }
                    $remaining_amt = $invoice->final_amount - $total_paid;
                    if(empty($invoice->booking_id) && $remaining_amt > 0) {
                        $edit_li = '<li><a class="dropdown-item" href="'. $edit_invoice .'" data-bs-toggletip="tooltip" data-bs-title="Edit Invoice"><i class="bi bi-pencil-square"></i> Edit</a></li>';
                        $sendpaylnk = '<li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggletip="tooltip" onclick="'.$payment_lnk.'" data-bs-title="Send Payment Link"><i class="bi bi-pencil-square"></i> Request Payment</a></li>';
                    }
                    elseif(!empty($invoice->booking_id) && $remaining_amt > 0) {
                        $edit_li = '<li><a class="dropdown-item" href="'. $edit_invoice .'" data-bs-toggletip="tooltip" data-bs-title="Edit Invoice"><i class="bi bi-pencil-square"></i> Edit</a></li>';
                        $sendpaylnk = '<li><a class="dropdown-item" href="'.$payment_lnk.'" data-bs-toggletip="tooltip" data-bs-title="Send Payment Link"><i class="bi bi-pencil-square"></i> Send Payment Link</a></li>';
                    }
                    else {
                        $edit_li = '<li><a class="dropdown-item" href="'. $edit_invoice .'" data-bs-toggletip="tooltip" data-bs-title="Edit Invoice"><i class="bi bi-pencil-square"></i> Edit</a></li>';
                    }
                    
                    $view_invoice = route('admin.view_invoice', $invoice->id);
                    $record_payment = route('admin.recordpayment', $invoice->id);
                    $download_link = route('admin.download.invoice', $invoice->id);
                    $copy_invoice = route('admin.copy_invoice', $invoice->id);
                    if($remaining_amt <= 0 ) {
                        $record_li = '';
                    }
                    else {
                        $record_li = '<li><a class="dropdown-item" href="' .$record_payment. '"><i class="bi bi-currency-dollar"></i> Record Payment</a></li>';
                    }
                    
                    $delete_inv = '<li><a class="dropdown-item" href="javascript:void(0);" onclick="' .$delete_invoice. '"><i class="bi bi-trash"></i> Delete</a></li>';
                    
                    $action_group = '<div class="btn-group">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                      </button>
                      <ul class="dropdown-menu" style="">
                        '.$edit_li.'
                        <li><a class="dropdown-item" href="'. $view_invoice .'"><i class="bi bi-eye"></i> View</a></li>
                        <li><a class="dropdown-item" href="'. $copy_invoice .'"><i class="bi bi-list-check"></i> Copy Invoice</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="' .$mail_popup. '" data-bs-toggle="modal" data-bs-target="#sendInvoiceMailModel"><i class="bi bi-envelope-arrow-up"></i> Send Invoice</a></li>
                        <li><a class="dropdown-item" href="'.$download_link.'"><i class="bi bi-download"></i> Download Invoice</a></li>

                        '.$sendpaylnk.$record_li.'
                        '.$delete_inv.'
                      </ul>
                    </div>';
                    return $action_group;
                })
                ->rawColumns(['status', 'invoice_sent', 'created_date', 'customer', 'total','amount_due', 'action'])
                ->make(true);
        }
    }

    public function invoiceForm($booking_id) {
        $data = Booking::where('id', $booking_id)->first();
        // echo '<pre>'; print_r($data); die;
        $service_ids = explode(',', $data->services);
        $services = Service::whereIn('id', $service_ids)->get();
        $data->service_details = $services;

        // get all service provider
        $providers = ServiceProvider::where('status', 1)->get();

        // All Active Services
        $services = Service::where('parent_id', '<>', 0)->where('status', 1)->get(['id', 'service_name']);
        // return view('admin.invoice.create_new', compact('services'));
        // $data->service_total = count($service_ids);
        // pr($data);die(' test');
        return view('admin.invoice.create', compact('data', 'services', 'providers'));
    }
    
    /**
     * New Invoice Form for create Seperate Invoice without any Appointment Confirmation
     */

    public function newInvoiceForm()
    {
        $provider = ServiceProvider::where('status', 1)->get(['id', 'first_name', 'last_name', 'license']);
        $services = Service::where('parent_id', '<>', 0)->where('status', 1)->get(['id', 'service_name']);
        return view('admin.invoice.create_new', compact('services', 'provider'));
    }

    /**
     * Create new Invoice for the Already created Appointment.
     */
    public function save(Request $request)
    {
        // pr($request->all());
        $request->validate([
            'customer_id' => 'required',
            'therapist_id' => 'required',
            'invoice_date' => 'required'
        ]);

        try {
            DB::beginTransaction();
            $invoice = new Invoice();
            // New way to generate Invoice Number
            $invoice->invoice_number = newGenerateInvoiceNumber(get_formatted_date($request->invoice_date, 'ymd'));
            
            $invoice->booking_id = $request->booking_id;
            $invoice->customer_id = $request->customer_id;
            $invoice->customer_name = $request->customer_name;
            $invoice->customer_email = $request->customer_email;
            $invoice->customer_mobile = $request->customer_mobile;
            $invoice->service_provider_id = $request->therapist_id;
            $invoice->booking_date = get_formatted_date($request->invoice_date, 'Y-m-d');
            $invoice->invoice_date = get_formatted_date($request->invoice_date, 'Y-m-d');
            $invoice->payment_due = date('Y-m-d');
            // $invoice->services = $request->services;
            $invoice->services = implode(',', $request->service_id);
            // $invoice->service_prices = implode(',',$request->row_total);
            $invoice->service_prices = implode(',', $request->row_total);
            $invoice->time_slots = $request->time_slots;
            $invoice->subtotal = $request->subtotal;
            $invoice->discount_type = $request->discount_type;
            $invoice->discount_type_val = $request->discount;
            $invoice->discount_value = $request->discount_val;
            $invoice->hst_tax = $request->hst_val;
            $invoice->final_amount = $request->grand_total;
            $invoice->notes = $request->notes;
            
            $invoice->save();
            DB::commit();
            if(isset($request->submit_pay)) {
                return redirect()->route('admin.recordpayment', $invoice->id)->with('success','Invoice Created Successfully!');
            }
            else {
                return redirect()->route('admin.invoices')->with('success','Invoice Created Successfully!');
            }
        }
        catch(Exception $e) {
            DB::rollBack();
            // die('Failed to create invoice: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }

    /**
     * This function is used to view Invoice 
     */
    public function view($id) 
    {
        $data = Invoice::with('payment')->where('id', $id)->first();
        $adrs = User::withTrashed()->where('id', $data->customer_id)->first(['family_id','address','city','state', 'postal_code']);
        if($adrs->family_id > 0) {
            $parent_addr = User::withTrashed()->where('family_id', $adrs->family_id)->first(['address','city','state','postal_code']);
        }
        // fetch service provider name
        $provider = ServiceProvider::where('id', $data->service_provider_id)->first();
        $data->therapist_name = $provider->first_name.' '.$provider->last_name;
        $data->therapist_license = $provider->license;
        $service_ids = explode(',', $data->services);
        $ser_prices = explode(',', $data->service_prices);
        $services = Service::whereIn('id', $service_ids)->get();
        $data->service_details = $services;
        $data->address = $adrs->address;
        $data->city = $adrs->city;
        $data->state = $adrs->state;
        $data->postal_code = $adrs->postal_code;
        
        $data->p_address = '';
        $data->p_city = '';
        $data->p_state = '';
        $data->p_postal_code = '';
        if(isset($parent_addr)) {
            $data->p_address = $parent_addr->address ?? '';
            $data->p_city = $parent_addr->city ?? '';
            $data->p_state = $parent_addr->state ?? '';
            $data->p_postal_code = $parent_addr->postal_code ?? '';
        }
        
        return view('admin.invoice.view', compact('data', 'ser_prices'));
    }

    /**
     * Save New Invoice Service Row
     */
    public function addServiceRow(Request $request)
    {
        $index = $request->get('index');
        $services = Service::where('parent_id', '<>', 0)->where('status', 1)->get(['id', 'service_name']);
        $row_html = '';
        if(!empty($services))
        {
            $options = '<option value="">Select</option>';
            foreach($services as $val) {
                $options .= '<option value="'.$val->id.'">'.$val->service_name.'</option>';
            }
            $row_html = '<tr><td><select name="service_id[]" id="service_id_'.$index.'" class="form-select" onchange="getServicePrice('.$index.');">'.$options.'</select></td><td><div id="duration_'.$index.'"></div></td><td>1</td><td><div id="row_total_div_'.$index.'">$<span id="spn_row_total_'.$index.'">0</span></div><input type="hidden" name="row_total[]" id="row_total_'.$index.'"><input type="hidden" name="is_taxable[]" id="is_taxable_'.$index.'"></td><td><button type="button" class="btn btn-sm btn-danger remove_row">X</button></td></tr>';
            return response()->json(['status' => true, 'row' => $row_html], 200);
        }
    }

    /**
     * This invoice has not link to Appointment
     */
    public function saveUnLinkedInvoice(Request $request)
    {
        $request->validate(
            [
                'therapist_id' => 'required',
                'customer_id' => 'required',
                'invoice_number' => [
                    'nullable',
                    Rule::unique('invoices')->whereNull('deleted_at'),
                ],
            ],
            [
                'therapist_id' => 'Please choose therapist name',
                'customer_id' => 'Please select client name'
            ]
        );

        try {
            DB::beginTransaction();
            $invoice = new Invoice();
            $invoice->invoice_number = newGenerateInvoiceNumber(get_formatted_date($request->invoice_date, 'ymd'));
          
            $invoice->customer_id = $request->customer_id;
            $invoice->service_provider_id = $request->therapist_id;
            $invoice->customer_name = $request->customer_name;
            $invoice->customer_email = $request->customer_email;
            $invoice->customer_mobile = $request->customer_mobile;
            // $invoice->therapist_name = $request->therapist_name;
            // $invoice->therapist_license = $request->therapist_license;
            $invoice->invoice_date = get_formatted_date($request->invoice_date, 'Y-m-d');
            $invoice->payment_due = date('Y-m-d');
            $invoice->services = implode(',', $request->service_id);
            $invoice->service_prices = implode(',', $request->row_total);
            $invoice->subtotal = $request->subtotal;
            $invoice->discount_type = $request->discount_type;
            $invoice->discount_type_val = $request->discount;
            $invoice->discount_value = $request->discount_val ?? 0;
            $invoice->hst_tax = $request->hst_val;
            $invoice->final_amount = $request->grand_total;
            $invoice->notes = $request->notes;

            $invoice->save();
            DB::commit();
            if(isset($request->submit_pay)) {
                // die('yes');
                return redirect()->route('admin.recordpayment', $invoice->id)->with('success','Invoice Created Successfully!');
            }
            else {
                // die('no');
                return redirect()->route('admin.invoices')->with('success','Invoice Created Successfully!');
            }
            
        }
        catch(Exception $e) {
            DB::rollBack();
            // die('Failed to create invoice: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }

    public function editNewInvoiceForm($id) 
    {
        $data = Invoice::where('id', $id)->first();
        $service_ids = explode(',',$data->services);
        $service_prices = explode(',', $data->service_prices);
        $data->ser_pri = $service_prices;
        $durations = Service::whereIn('id', $service_ids)->get(['duration']);
        
        $duration = [];
        $i = 0;
        foreach($durations as $val) {
            $duration[$i] = $val->duration;
            $i++;
        }
        // pr($duration);die;
        $services = Service::where('parent_id', '<>', 0)->where('status', 1)->get(['id', 'service_name']);
        return view('admin.invoice.edit_new', compact('data', 'services', 'service_ids','duration'));
    }

    public function saveEditedInvoice(Request $request)
    {
        // pr($request->all());
        $request->validate([
            'customer_id' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $invoice = Invoice::findOrFail($request->id);
            
            if($invoice->invoice_date != get_formatted_date($request->invoice_date, 'Y-m-d')) {
                $invoice->invoice_number = newGenerateInvoiceNumber(get_formatted_date($request->invoice_date, 'ymd'));
            }

            $invoice->customer_id = $request->customer_id;
            $invoice->customer_name = $request->customer_name;
            $invoice->customer_email = $request->customer_email;
            $invoice->customer_mobile = $request->customer_mobile;

            $invoice->therapist_name = $request->therapist_name;
            $invoice->therapist_license = $request->therapist_license;

            $invoice->invoice_date = get_formatted_date($request->invoice_date, 'Y-m-d');
            $invoice->payment_due = date('Y-m-d');
            $invoice->services = implode(',', $request->service_id);
            $invoice->service_prices = implode(',', $request->row_total);
            $invoice->subtotal = $request->subtotal;
            $invoice->discount_type = $request->discount_type;
            $invoice->discount_type_val = $request->discount;
            $invoice->discount_value = $request->discount_val ?? 0;
            $invoice->hst_tax = $request->hst_val;
            $invoice->notes = $request->notes;

            $pmt_status = $invoice->payment_status; // before update payment status.
            if($pmt_status == 'paid') {
                $invoice->payment_status = 'pending';
                $invoice->final_amount = $request->grand_total;
                $invoice->save();
                Payment::where('invoice_id', $request->id)->forceDelete();
            }
            else {
                $pay = Payment::where('invoice_id', $request->id)->first();
                // pr($pay); die;
                if(($request->grand_total != $invoice->final_amount) && !isset($pay)) {
                    $invoice->final_amount = $request->grand_total;
                    $invoice->payment_status = 'pending';
                }
                else if(isset($pay) && $request->grand_total != $pay->paid_amount) {
                    $invoice->payment_status = 'partial';
                }
                // pr($invoice); die(' Test');
                $invoice->save();

                // update Payment table 
                $checkPayment = Payment::where('invoice_id', $request->id)->first();
                if(!empty($checkPayment)) {
                    Payment::where('invoice_id', $request->id)->update(['total_amount' => $request->grand_total]);
                }
            }

            DB::commit();
            return redirect()->route('admin.invoices')->with('success','Invoice Updated Successfully!');
        }
        catch(Exception $e) {
            DB::rollBack();
            // die('Failed to create invoice: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }

    /**
     * Get the Email id and show in the pop-up of send invoice-mail
    */
    public function invoiceMailId(Request $request) 
    {
        // pr($request->toArray());die;
        $data = Invoice::find($request->invoice_id);
        // pr($data);die;
        return response()->json(['status' => true, 'id' => $request->invoice_id, 'email' => $data->customer_email]);
    }

    public function sendInvoice(Request $request) 
    {
        $id = $request->id;
        $setting = getSetting();
        $data = Invoice::with('payment')->where('id', $id)->first();

        $service_ids = explode(',', $data->services);
        $ser_prices = explode(',', $data->service_prices);
        $user_detail = User::withTrashed()->where('id', $data->customer_id)->first(['first_name','family_id', 'address', 'city','state','postal_code']);
        
        if($user_detail->family_id > 0) {
            $parent_addr = User::withTrashed()->where('family_id', $user_detail->family_id)->first(['address','city','state','postal_code']);
        }
        
        $services = Service::whereIn('id', $service_ids)->get();
        $data->service_details = $services;
        $data->user_dtl = $user_detail;
        $data->ser_price = $ser_prices;

        $data->address = $user_detail->address;
        $data->city = $user_detail->city;
        $data->state = $user_detail->state;
        $data->postal_code = $user_detail->postal_code;

        $data->p_address = '';
        $data->p_city = '';
        $data->p_state = '';
        $data->p_postal_code = '';
        if(isset($parent_addr)) {
            $data->p_address = $parent_addr->address ?? '';
            $data->p_city = $parent_addr->city ?? '';
            $data->p_state = $parent_addr->state ?? '';
            $data->p_postal_code = $parent_addr->postal_code ?? '';
        }
        
        // Send Mail to customer
        if($setting->global_mail == 1) {
            $default_mail = $request->default_mail;
            $other_single_email = $request->other_single_email;
            $to = '';
            $cc = '';
            if(!empty($default_mail) && empty($other_single_email)) {
                $to = $default_mail;
            }
            if(empty($default_mail) && !empty($other_single_email)) {
                $to = $other_single_email;
            }
            if(!empty($default_mail) && !empty($other_single_email)) {
                $to = $default_mail;
                $cc = $other_single_email;
            }
            if(empty($cc)) {
                $done = Mail::to('mca.asheesh@gmail.com')->send(new InvoiceMail($data));
            }
            else {
                $done = Mail::to($to)->cc($cc)->send(new InvoiceMail($data));
            }
            if($done) {
                Invoice::where('id', $id)->update(['invoice_sent_date' => date('Y-m-d H:i:s')]);
            }
        }
        return response()->json(['status' => true, 'message' => 'Invoice Mail sent Successfully']);
    }

    public function delete($id)
    {
        try {
            $invoice = Invoice::find($id);
            if($invoice) {
                if($invoice->payment_status == 'paid') {
                    // Parmanent Delete
                    Invoice::withTrashed()->find($id)->forceDelete();
                }
                else {
                    // Soft Delete
                    $invoice->delete();
                }
                  // It is doing soft delete because of we set soft delete in Invoice Model;
                return response()->json(['status' => true, 'message' => 'Invoice deleted successfully']);
            }
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Invoice Could not deleted, Please Try again '.$e->getMessage()]);
        }

        // Restore invoice (and its payments)
        // Invoice::withTrashed()->find($id)->restore();

        // Permanently delete invoice (and its payments)
        // Invoice::withTrashed()->find($id)->forceDelete();
    }

    public function download($id) 
    {
        $data = Invoice::with('payment')->where('id', $id)->first();
        $adrs = User::withTrashed()->where('id', $data->customer_id)->first(['family_id', 'address', 'city', 'state', 'postal_code']);
        if($adrs->family_id > 0) {
            $parent_addr = User::withTrashed()->where('family_id', $adrs->family_id)->first(['address','city','state','postal_code']);
        }

        // fetch service provider name
        $provider = ServiceProvider::where('id', $data->service_provider_id)->first();
        $data->therapist_name = $provider->first_name.' '.$provider->last_name;
        $data->therapist_license = $provider->license;
        
        $service_ids = explode(',', $data->services);
        $ser_prices = explode(',', $data->service_prices);
        $services = Service::whereIn('id', $service_ids)->get();
        $data->service_details = $services;
        $data->address = $adrs->address;
        $data->city = $adrs->city;
        $data->state = $adrs->state;
        $data->postal_code = $adrs->postal_code;

        $data->p_address = '';
        $data->p_city = '';
        $data->p_state = '';
        $data->p_postal_code = '';
        if(isset($parent_addr)) {
            $data->p_address = $parent_addr->address ?? '';
            $data->p_city = $parent_addr->city ?? '';
            $data->p_state = $parent_addr->state ?? '';
            $data->p_postal_code = $parent_addr->postal_code ?? '';
        }
        
        $pdf = Pdf::loadView('admin.invoice.invoice_pdf_statement', [
            'data' => $data,
            'ser_prices' => $ser_prices
        ]);

        return $pdf->download('inv_'.$data->invoice_number.'.pdf');
    }

    public function showCopyInvoiceForm(Request $request)
    {
        $data = Invoice::findOrFail($request->id);
        $service_ids = explode(',',$data->services);
        $service_prices = explode(',', $data->service_prices);
        $data->ser_pri = $service_prices;
        $durations = Service::whereIn('id', $service_ids)->get(['duration']);
        
        $duration = [];
        $i = 0;
        foreach($durations as $val) {
            $duration[$i] = $val->duration;
            $i++;
        }
        // pr($duration);die;
        $services = Service::where('parent_id', '<>', 0)->where('status', 1)->get(['id', 'service_name']);
        return view('admin.invoice.duplicate_invoice', compact('data', 'services', 'service_ids','duration'));
    }

    public function sendGeneratedPaymentLnk(Request $request)
    {
        $data = Invoice::with('payment')->where('id', $request->id)->first();

        // getting invoice pdf data
        $service_ids = explode(',', $data->services);
        $ser_prices = explode(',', $data->service_prices);
        $user_detail = User::withTrashed()->where('id', $data->customer_id)->first(['first_name','family_id', 'address', 'city','state','postal_code']);
        
        if($user_detail->family_id > 0) {
            $parent_addr = User::withTrashed()->where('family_id', $user_detail->family_id)->first(['address','city','state','postal_code']);
        }
        
        $services = Service::whereIn('id', $service_ids)->get();
        $data->service_details = $services;
        $data->user_dtl = $user_detail;
        $data->ser_price = $ser_prices;

        $data->address = $user_detail->address;
        $data->city = $user_detail->city;
        $data->state = $user_detail->state;
        $data->postal_code = $user_detail->postal_code;

        $data->p_address = '';
        $data->p_city = '';
        $data->p_state = '';
        $data->p_postal_code = '';
        if(isset($parent_addr)) {
            $data->p_address = $parent_addr->address ?? '';
            $data->p_city = $parent_addr->city ?? '';
            $data->p_state = $parent_addr->state ?? '';
            $data->p_postal_code = $parent_addr->postal_code ?? '';
        }
        // End Here

        if(!empty($data->payment)) {
            $total_paid = $data->payment->paid_amount;
            $invoiced_amt = $data->final_amount - $total_paid;
        }
        else {
            $invoiced_amt = $data->final_amount;
        }

        // For Square payment Gateway
        $amount_in_cents = (int)($invoiced_amt * 100);

        $environment = config('square.environment') === 'production' ? Environments::Production : Environments::Sandbox;

        $client = new SquareClient(
            token: config('square.access_token'),
            options: [
                'baseUrl' => $environment->value
            ]
        );

        $order = new Order([
            'locationId' => config('square.location_id'),
            'lineItems' => [
                new OrderLineItem([
                    'name' => 'Invoice Payment - ' . $data->invoice_number,
                    'quantity' => '1',
                    'basePriceMoney' => new Money([
                        'amount' => $amount_in_cents,
                        'currency' => 'CAD'
                    ])
                ])
            ]
        ]);

        $createPaymentLinkRequest = new CreatePaymentLinkRequest([
            'idempotency_key' => uniqid(),
            'order' => $order,
            'checkout_options' => [
                'redirect_url' => route('thanks'), // or a thank you page
                'merchant_support_email' => config('mail.from.address', 'ashcool007@gmail.com')
            ]
        ]);

        $response = $client->checkout->paymentLinks->create($createPaymentLinkRequest);

        if ($response->getErrors()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create payment link.',
                'errors' => $response->getErrors()
            ], 400);
        }

        $paymentLink = $response->getPaymentLink()->getUrl();
        $paymentLinkId = $response->getPaymentLink()->getId();
        $orderId = $response->getPaymentLink()->getOrderId();

        if(!empty($data->payment)) {
            Payment::where('invoice_id', $request->id)->update([
                'payment_link_id' => $paymentLinkId, 
                'square_order_id' => $orderId, 
                'invoiced_amt' => $invoiced_amt, 
                'square_status' => 'pending'
                ]);
        }
        else {
            Payment::create([
                'invoice_id' => $request->id,
                'payment_link_id' => $paymentLinkId, 
                'square_order_id' => $orderId, 
                'invoiced_amt' => $invoiced_amt, 
                'square_status' => 'pending'
            ]);
        }

            // Send email to customer
            $setting = getSetting();
            if($setting->global_mail == 1) {
                $customeremail = 'mca.asheesh@gmail.com';
                Mail::to($customeremail)->send(new InvoicePaymentLink($data, $paymentLink, $amount_in_cents));
            }

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'payment_link' => $paymentLink,
                    'message' => 'Payment link created successfully.' . ($setting->global_mail == 1 ? ' Email sent to customer.' : '')
                ]);
            } else {
                return redirect()->route('admin.invoices')->with('success', 'Payment link created successfully.' . ($setting->global_mail == 1 ? ' Email sent to customer.' : ''));
            }
        

        if ($request->ajax()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create payment link.',
                'errors' => $response->getErrors()
            ], 400);
        } else {
            return redirect()->back()->withErrors(['error' => 'Failed to create payment link.']);
        }
    }
}
