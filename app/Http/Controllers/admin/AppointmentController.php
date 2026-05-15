<?php

namespace App\Http\Controllers\admin;

use App\Mail\sendMedicalFormMail;
use App\Http\Controllers\Controller;
use App\Mail\AppointmentStatusCanceledMail;
use App\Mail\AppointmentStatusConfirmedMail;
use App\Mail\AppointmentStatusDeclinedMail;
use App\Mail\RescheduleAppointmentMail;
use App\Models\BlockDate;
use App\Models\Booking;
use App\Models\HolidayList;
use App\Models\SmsTemplate;
use App\Models\Service;
use App\Models\User;
use App\Models\WeeklySchedule;
use App\Models\BlockTimeRange;
use App\Models\DateOverride;
use App\Models\ServiceProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Services\TwilioService;

class AppointmentController extends Controller
{
    /**
     * Show the Appointment Listing 
     */
    public function index(Request $request)
    {
        $status = $request->get('status'); // Get status from query parameter
        return view('admin.appointment.index', compact('status'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $bookings = Booking::with('customer')
            ->leftJoin('users', 'users.id', '=', 'bookings.customer_id')
            ->select('bookings.*')
            ->addSelect('users.last_name as sort_last_name');

            // Apply status filter if provided
            if ($request->has('status') && !empty($request->status)) {
                $bookings->where('booking_status', $request->status);
            }

            if($request->app_st && $request->app_ed) {
                $bookings->whereBetween('booking_date', [
                    get_formatted_date($request->app_st, 'Y-m-d'),
                    get_formatted_date($request->app_ed, 'Y-m-d')
                ]);
            }
            elseif($request->app_st) {
                $bookings->whereDate('booking_date', '>=', $request->get_formatted_date($request->app_st, 'Y-m-d'));
            }
            elseif($request->app_ed) {
                $bookings->whereDate('booking_date', '<=', $request->get_formatted_date($request->app_ed, 'Y-m-d'));
            }
            else {
                $bookings->whereDate('booking_date', '>=', date('Y-m-d'));
            }

            return DataTables::of($bookings)
                ->addIndexColumn()
                ->addColumn('customer_name', function ($booking) {
                    $first = $booking->customer->first_name ?? '';
                    $last = $booking->customer->last_name ?? '';
                    if(empty($last)) {
                        $name = trim($first);
                    }
                    else {
                        $name = trim("$last, $first");
                    }
                    
                    $profile_link = route('admin.userprofile', $booking->customer_id);
                    return '<div><a href="'.$profile_link.'" class="text-decoration-none" data-bs-toggletip="tooltip" data-bs-title="'.$name.', '.$booking->customer_mobile.', '.$booking->customer_email.'">' . ucwords($name) . '</a></div>';
                })
                ->addColumn('date_time', function ($booking) {
                    $starting_slot = explode(',', $booking->time_slots);
                    return get_formatted_date($booking->booking_date, 'M d, Y') . '<br> ' . $starting_slot[0];
                })
                ->addColumn('duration', function ($booking){
                    $duration = 30;
                    $slots = explode(',', $booking->time_slots);
                    return $duration * count($slots);
                })
                ->addColumn('services', function ($booking) {
                    $serviceIds = explode(',', $booking->services);
                    $serviceNames = Service::whereIn('id', $serviceIds)->pluck('service_name')->toArray();
                    return implode(', ', $serviceNames);
                })
                ->addColumn('status', function ($booking) {
                    $status = strtolower($booking->booking_status);
                    $badges = [
                        'confirmed' => 'primary',
                        'completed' => 'success',
                        'canceled'  => 'danger',
                        'pending'   => 'warning',
                    ];
                    $color = $badges[$status] ?? 'secondary';

                    return '<div><span class="badge text-bg-' . $color . '">' . ucfirst($status) . '</span></div>';
                })
                ->addColumn('action', function($booking){
                    $editAppointment = route('admin.edit_appointment', $booking->id);
                    $rebookAppointment = route('admin.add.appointment', $booking->id);

                    $updateStatus = "updateAppointmentStatus(this, '".$booking->id."')";
                    $viewDetail = "viewBookingDetail('".$booking->id."')";
                    $deleteAppointment = "deleteAppointment('".$booking->id."')";
                    $sendMedicalForm = "sendMedicalForm('".$booking->customer_id."')";
                    $create_invoice = route('admin.invoice_form', $booking->id);
                    $genrate_soap_note = route('admin.generate_soapnote', $booking->id);
                    $delete_action = '<li><a class="dropdown-item" href="javascript:void(0);" onclick="'.$deleteAppointment.'"><i class="bi bi-trash"></i> Delete</a></li>';
                        if($booking->booking_status == 'declined' || $booking->booking_status == 'canceled') {
                            $edit_action = '';
                            $cancel_action = '';
                            $decline_action = '';
                            $create_inv = '';
                            $send_medical_form = '';
                            $generate_soap_note = '';
                            $confirm_action = '<li><a class="dropdown-item" href="'.$rebookAppointment.'" data-value="rebook"><i class="bi bi-check-lg text-info"></i> Re-Book</a></li>';
                        }    
                        else {
                            $edit_action = '<li><a class="dropdown-item" href="'.$editAppointment.'"><i class="bi bi-pencil"></i> Edit</a></li>';
                            $confirm_action = '<li><a class="dropdown-item" href="javascript:void(0);" onclick="'.$updateStatus.'" data-value="confirmed"><i class="bi bi-check-lg text-info"></i> Confirm</a></li>';

                            $cancel_action = '<li><a class="dropdown-item" href="javascript:void(0);" onclick="'.$updateStatus.'" data-value="canceled"><i class="bi bi-x-lg text-danger"></i> Cancel</a></li>';
                            $decline_action = '<li><a class="dropdown-item" href="javascript:void(0);" onclick="'.$updateStatus.'" data-value="declined"><i class="bi bi-ban text-danger"></i> Decline</a></li>';

                            $create_inv = '<li><a id="inv_'.$booking->id.'" class="dropdown-item" href="'.$create_invoice.'"><div class="d-none" id="div_inv_'.$booking->id.'" style="width:0.8rem; height:0.8rem;"></div><i class="bi bi-receipt" id="inv_'.$booking->id.'"></i> Create Invoice</a></li>';
                            $send_medical_form = '<li><a id="a_'.$booking->id.'" class="dropdown-item" href="javascript:void(0);" onclick="'.$sendMedicalForm.'"><div class="d-none" id="sp_smf_'.$booking->id.'" style="width:0.8rem; height:0.8rem;"></div><i class="bi bi-send-arrow-up" id="i_'.$booking->id.'"></i> Send Medical Form</a></li>';
                            $generate_soap_note = '<li><a class="dropdown-item" href="'.$genrate_soap_note.'"><div class="d-none" style="width:0.8rem; height:0.8rem;"></div><i class="bi bi-node-plus" id="soap_'.$booking->id.'"></i> Generate SOAP Notes</a></li>';
                        }

                        if($booking->booking_status == 'completed') {
                            $edit_action = '';
                            $confirm_action = '';
                            $cancel_action = '';
                            $decline_action = '';
                            $create_inv = '';
                            $send_medical_form = '';
                            $generate_soap_note = '';
                        }
                    $action = '<div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu" style="">
                                    
                                    '.$edit_action.'
                                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="'.$viewDetail.'" data-bs-toggle="modal" data-bs-target="#appointmentDetailPop" data-bs-whatever="appointmentDetailPop"><i class="bi bi-binoculars"></i> View</a></li>

                                    '.$confirm_action.'

                                    '.$cancel_action.'
                                    '.$decline_action.'

                                    '.$create_inv.'
                                    
                                    '.$send_medical_form.'

                                    '.$generate_soap_note.$delete_action.'
                                </ul>
                            </div>';
                    return $action;
                })
                ->orderColumn('customer_name', function ($query, $order) {
                    $query->orderBy('sort_last_name', $order);
                })
                ->orderColumn('date_time', function ($query, $order) {
                    $setorder = 'asc';
                    $query
                        ->orderBy('bookings.booking_date', $order)
                        ->orderByRaw("
                            STR_TO_DATE(
                                SUBSTRING_INDEX(bookings.time_slots, ',', 1),
                                '%h:%i%p'
                            ) {$setorder}
                        ");
                })
                ->filterColumn('customer_name', function($query, $keyword) {
                    $query->whereHas('customer', function($q) use ($keyword) {
                        $q->where('first_name', 'like', "%{$keyword}%")
                        ->orWhere('last_name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('services', function($query, $keyword) {
                    $query->whereRaw("EXISTS (
                        SELECT 1 FROM services 
                        WHERE FIND_IN_SET(services.id, bookings.services) 
                        AND services.service_name LIKE ?
                    )", ["%{$keyword}%"]);
                })
                
                ->rawColumns(['customer_name','services', 'date_time', 'duration', 'status', 'action']) // in case of <br> or HTML in future
                ->make(true);
        }
    }

    public function viewBookingDetail(Request $request, $id)
    {
        $booking = Booking::with('customer')->findOrFail($id);
        // Get service names
        $serviceIds = explode(',', $booking->services);
        $serviceNames = Service::whereIn('id', $serviceIds)->pluck('service_name')->toArray();
        // pr($serviceNames); die;
        return response()->json([
            'status' => true, 'booking' => $booking, 'services' => $serviceNames
        ]);
    }

    public function sendMedicalForm(Request $request, $customer_id)
    {
        // Check booking Status
        try{
            $customer_data = User::where('id', $customer_id)->first();
            $sent_to = $customer_data->email;
            if(empty($customer_data->email)) {
                // If customer email id not exist then use parent mail id to send medical form.
                $customer_email = User::where('family_id', $customer_data->family_id)->where('email','!=', '')->whereNotNull('email')->first(['email']);
                $sent_to = $customer_email->email;
            }
            $encryped_customer_id = Crypt::encryptString($customer_data->id);
            $medical_form_link = route('medical_form', $encryped_customer_id);
            $setting = getSetting();
            if($setting->global_mail == 1) {
                $fullname = ($customer_data->last_name) ? $customer_data->first_name.' '.$customer_data->last_name : $customer_data->first_name;
                Mail::to('mca.asheesh@gmail.com')->send(new sendMedicalFormMail($fullname, $medical_form_link));
            }
            return response()->json(['status' => true, 'message' => 'Medical Form Sent to Customer Successfully!'], 200);
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Form Could not be sent '. $e->getMessage()], 500);
        }
        
    }

    public function updateAppointmentStatus(Request $request)
    {
        try {
            $setting = getSetting();
            $id = $request->id;
            $status = $request->status;
            DB::beginTransaction();
            $booking = Booking::findOrFail($id);
            Booking::where('id', $id)->update(['booking_status' => $status]);
            $serviceIds = explode(',', $booking->services);
            $serviceNames = Service::whereIn('id', $serviceIds)->pluck('service_name')->toArray();
            $parent_ids = Service::whereIn('id', $serviceIds)->pluck('parent_id')->toArray();
            $duration = Service::whereIn('id', $serviceIds)->pluck('duration')->toArray();
            $parent_servicename = Service::whereIn('id', $parent_ids)->pluck('service_name')->toArray();
            $booking->service_names = implode(',',$serviceNames);
            $booking->parent_service_name = implode(',', $parent_servicename);
            $booking->parent_ids = $parent_ids;
            $booking->duration = $duration;

            // Medical Form Link
            $encrypted_customer_id = Crypt::encryptString($booking->customer_id);
            $medical_form_link = route('medical_form', $encrypted_customer_id);
            if($setting->global_mail == 1) {
                if($status == 'confirmed') {
                    Mail::to($booking->customer_email)->send(new AppointmentStatusConfirmedMail($booking, $medical_form_link));
                }
                if($status == 'completed') {
                    // Mail::to($booking->customer_email)->send(new)
                }
                if($status == 'canceled') {
                    Mail::to($booking->customer_email)->send(new AppointmentStatusCanceledMail($booking, $status));
                }
                if($status == 'declined') {
                    Mail::to($booking->customer_email)->send(new AppointmentStatusDeclinedMail($booking, $status, $medical_form_link));
                }
            }

            // Send SMS to Client For booking status
            if($booking->parent_ids[0] == 1) {
                $ser = 'RMT Massage Therapy';
            }
            else {
                $ser = $booking->parent_service_name;
            }
            $lastspace = strpos($booking->customer_name, ' ');
            $first_name = substr($booking->customer_name, 0, $lastspace);
            if($status == 'confirmed') {
                $sms_content = SmsTemplate::where('sms_key', 'appointment_confirm')->where('status', 1)->first();
                $placeholder = [
                    '[user]' => ucwords($first_name),
                    '[service]' => $ser,
                    '[date]' => get_formatted_date($booking->booking_date, 'F d, Y'),
                    '[time]' => explode(',', $booking->time_slots)[0],
                ];
                $body = str_replace(array_keys($placeholder), array_values($placeholder), $sms_content->body);
                $sms_message = $body;
            }
            if($status == 'canceled') {
                $sms_content = SmsTemplate::where('sms_key', 'appointment_cancel')->where('status', 1)->first();
                $placeholder = [
                    '[user]' => ucwords($first_name),
                    '[service]' => $ser,
                    '[date]' => get_formatted_date($booking->booking_date, 'F d, Y'),
                    '[time]' => explode(',', $booking->time_slots)[0],
                ];
                $body = str_replace(array_keys($placeholder), array_values($placeholder), $sms_content->body);
                $sms_message = $body;
            }
            if($status == 'declined') {
                $sms_content = SmsTemplate::where('sms_key', 'appointment_decline')->where('status', 1)->first();
                $placeholder = [
                    '[user]' => ucwords($first_name),
                    '[service]' => $ser,
                    '[date]' => get_formatted_date($booking->booking_date, 'F d, Y'),
                    '[time]' => explode(',', $booking->time_slots)[0],
                ];
                $body = str_replace(array_keys($placeholder), array_values($placeholder), $sms_content->body);
                $sms_message = $body;
            }
            $objTwilio = new TwilioService();
            $objTwilio->sendSms($booking->customer_mobile, $sms_message);
            
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Appointment Status '.ucfirst($status).' Successfully!'], 200);
        }
        catch(Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Some Technical Issues here '.$e->getMessage()]);
        }
    }

    /**
     * Show the Add Appointment Screen to book Appointment from Backend
     */
    public function add($id = null)
    {
        if(!empty($id)) {
            $prev_booking = Booking::where('id', $id)->first(['id', 'customer_id', 'customer_name', 'customer_email', 'customer_mobile','services','booking_date', 'created_at']);
        }
        else {
            $prev_booking = '';
        }

        $serv_provider = ServiceProvider::where('status', 1)->get(['id', 'first_name', 'last_name', 'license']);
        $main_services = Service::where('status', '1')->where('parent_id', 0)->get(); // Parent Service Name
        $sub_service = Service::where('status', '1')->where('parent_id', '<>', 0)->get(); // Childs of Service Name
        if($main_services)
        {
            $all_services = array();
            foreach($main_services as $val) {
                $j = 0;
                foreach($sub_service as $service) {
                    if($val->id == $service->parent_id) {
                        $all_services[$val->service_name][$j]['id'] = $service->id;
                        $all_services[$val->service_name][$j]['service_name'] = $service->service_name;
                        $all_services[$val->service_name][$j]['duration'] = $service->duration;
                        $all_services[$val->service_name][$j]['price'] = $service->price;
                    }
                    $j++;
                }
            }
        }
        
        return view('admin.appointment.add', compact('all_services', 'prev_booking', 'serv_provider'));
    }

    /**
     * Check Date and time availability for book the appointment.
     */
    public function checkAvailability()
    {
        $setting = getSetting();
        $data = request()->all();
        $service_ids = $data['services'];

        $services = Service::whereIn('id', $service_ids)
            ->get(['id','service_name', 'price', 'duration']);

        $required_duration = $services->sum('duration');

        $input_dt = get_formatted_date($data['appoint_dt'], 'Y-m-d');
        $dayNumber = date('N', strtotime($input_dt)); // 1=Monday, 7=Sunday

        // Default Clinic Timings
        $default_clinic_start = $setting->start_time;
        $default_clinic_end = $setting->end_time;

        // clinic default open time slots
        $clinic_default_timings = generateTimeSlots(date('H:i', strtotime($default_clinic_start)), date('H:i', strtotime($default_clinic_end)), $setting->duration);

        // -----------------------------
        // 1. GET WEEKLY SCHEDULE
        // -----------------------------
        $weekly_schedule = WeeklySchedule::where('day_of_week', $dayNumber)->first();

        if (!$weekly_schedule) {
            // If no weekly schedule exists, use default clinic times
            $clinic_start = $default_clinic_start;
            $clinic_end = $default_clinic_end;
            $is_closed = false;
            $lunch_start = null;
            $lunch_end = null;
        } else {
            $is_closed = $weekly_schedule->is_closed == 1;
            if ($is_closed) {
                $clinic_start = null;
                $clinic_end = null;
            } else {
                $clinic_start = $weekly_schedule->start_time ?: $default_clinic_start;
                $clinic_end = $weekly_schedule->end_time ?: $default_clinic_end;
            }
            $lunch_start = $weekly_schedule->lunch_start;
            $lunch_end = $weekly_schedule->lunch_end;
        }

        // -----------------------------
        // 2. APPLY DATE OVERRIDES
        // -----------------------------
        $date_override = DateOverride::where('date', $input_dt)->first();
        if ($date_override) {
            if ($date_override->is_closed) {
                $clinic_start = null;
                $clinic_end = null;
                $is_closed = true;
            } else {
                $clinic_start = $date_override->custom_start_time ?: $clinic_start;
                $clinic_end = $date_override->custom_end_time ?: $clinic_end;
                $is_closed = false;
            }
        }

        // If clinic is closed, no slots available
        if ($is_closed) {
            $allSlots = $clinic_default_timings;
            $blocked_slots = $clinic_default_timings;
        } else {
            // Subtract one slot duration from end time so the last slot is excluded
            $clinic_end_exclusive = date('H:i', strtotime($clinic_end) - ($setting->duration * 60));
            // Generate time slots based on clinic hours
            $allSlots = generateTimeSlots(date('H:i', strtotime($clinic_start)), $clinic_end_exclusive);
            $blocked_slots = [];
        }

        // -----------------------------
        // 3. GET BLOCKED TIME RANGES
        // -----------------------------
        
        $lunch_slots = [];
        $is_day_blocked = false;

        // Add lunch time slots if they exist
        if ($lunch_start && $lunch_end && !$is_closed) {
            // calculate 30 min less by end lunch time for make available last lunch time shown in admin panel
            $lunch_end_exclusive = date('H:i', strtotime($lunch_end) - ($setting->duration * 60));
            $lunch_slots_array = generateTimeSlots(date('H:i', strtotime($lunch_start)), $lunch_end_exclusive);
            $lunch_slots = array_merge($lunch_slots, $lunch_slots_array);
        }

        // Get block time ranges that apply to this date
        $block_ranges = BlockTimeRange::where(function($query) use ($input_dt, $dayNumber) {

            // =====================================================
            // WEEKLY BLOCK WITH DATE RANGE
            // =====================================================
            $query->where(function($q) use ($input_dt, $dayNumber) {

                $q->where('type', 'weekly')
                ->where('day_of_week', $dayNumber)

                // IMPORTANT
                ->where(function($dateQuery) use ($input_dt) {

                    // no date restriction (forever weekly)
                    $dateQuery->whereNull('start_date')
                                ->whereNull('end_date')

                    // OR date range restriction
                    ->orWhere(function($rangeQuery) use ($input_dt) {

                        $rangeQuery->whereDate('start_date', '<=', $input_dt)
                                    ->whereDate('end_date', '>=', $input_dt);
                    });
                });
            })

            // =====================================================
            // EXACT DATE BLOCK
            // =====================================================
            ->orWhere(function($q) use ($input_dt) {

                $q->where('type', 'date')
                ->whereDate('start_date', $input_dt);
            })

            // =====================================================
            // RANGE BLOCK
            // =====================================================
            ->orWhere(function($q) use ($input_dt) {

                $q->where('type', 'range')
                ->whereDate('start_date', '<=', $input_dt)
                ->whereDate('end_date', '>=', $input_dt);
            });

        })->get();
        
        if($block_ranges->isNotEmpty()) {
            foreach ($block_ranges as $block) {
                if ($block->is_full_day) {
                    // Block entire day
                    $blocked_slots = array_merge($blocked_slots, $clinic_default_timings);
                    $is_day_blocked = true;
                } else {
                    // Block specific time range
                    $block_slots = generateTimeSlots(
                        date('H:i', strtotime($block->start_time)),
                        date('H:i', strtotime($block->end_time))
                    );
                    $blocked_slots = array_merge($blocked_slots, $block_slots);
                }
            }
        }

        // Remove duplicates
        $blocked_slots = array_unique($blocked_slots);
        $lunch_slots = array_unique($lunch_slots);

        // -----------------------------
        // 4. GET EXISTING BOOKINGS
        // -----------------------------
        $bookings = Booking::where('booking_date', $input_dt)
            ->whereNotIn('booking_status', ['canceled','declined'])
            ->pluck('time_slots')
            ->flatMap(fn($s) => explode(',', $s))
            ->toArray();

        // -----------------------------
        // 6. GENERATE SLOT HTML WITH COLORS
        // -----------------------------
        $slot_html = '';
        $block_type = $is_day_blocked ? 'Day is blocked' : '';
        foreach ($allSlots as $slot) {
            $isLunch = in_array($slot, $lunch_slots);
            $isBlocked = in_array($slot, $blocked_slots);
            $isBooked = in_array($slot, $bookings);

            if ($isBooked) {
                $class = 'slot_brd disable_slots engaged';
                $title = 'Already Booked';
            } elseif ($isBlocked) {
                $class = 'slot_brd blocked_slot'; // Admin can still select blocked slots
                $title = $is_day_blocked ? 'Day is blocked (Admin can book)' : 'Blocked Time (Admin can book)';
            } elseif ($isLunch) {
                $class = 'slot_brd lunch_slot';
                $title = 'Lunch Time';
            } else {
                $class = 'slot_brd';
                // $style = '';
                $title = 'Available';
            }

            $slot_html .= '
                <div class="col-md-4 col-sm-6 mt-3">
                    <div class="btn '.$class.' bg-white text-body text-uppercase p-2 w-100"
                        data-value="'.$slot.'"
                        data-duration="'.$required_duration.'"
                        data-booked="'.($isBooked ? 1 : 0).'"
                        data-blocked="'.($isBlocked ? 1 : 0).'"
                        data-lunch="'.($isLunch ? 1 : 0).'"
                        title="'.$title.'">
                        '.$slot.'
                    </div>
                </div>';
        }

        return response()->json([
            'status' => 200,
            'message' => $slot_html,
            'duration' => $required_duration,
            'block_type' => $block_type,
            'cli_endtm' => $clinic_end
        ]);
    }
    
    public function checkAvailabilityInEdit()
    {
        $setting = getSetting();
        $data = request()->all();
        $service_ids = $data['services'];

        $services = Service::whereIn('id', $service_ids)
            ->get(['id','service_name', 'price', 'duration']);

        $required_duration = $services->sum('duration');

        $input_dt = get_formatted_date($data['appoint_dt'], 'Y-m-d');
        $dayNumber = date('N', strtotime($input_dt)); // 1=Monday, 7=Sunday

        // Default Clinic Timings
        $default_clinic_start = $setting->start_time;
        $default_clinic_end = $setting->end_time;

        // clinic default open time slots
        $clinic_default_timings = generateTimeSlots(date('H:i', strtotime($default_clinic_start)), date('H:i', strtotime($default_clinic_end)), $setting->duration);

        // -----------------------------
        // 1. GET WEEKLY SCHEDULE
        // -----------------------------
        $weekly_schedule = WeeklySchedule::where('day_of_week', $dayNumber)->first();

        if (!$weekly_schedule) {
            // If no weekly schedule exists, use default clinic times
            $clinic_start = $default_clinic_start;
            $clinic_end = $default_clinic_end;
            $is_closed = false;
            $lunch_start = null;
            $lunch_end = null;
        } else {
            $is_closed = $weekly_schedule->is_closed == 1;
            if ($is_closed) {
                $clinic_start = null;
                $clinic_end = null;
            } else {
                $clinic_start = $weekly_schedule->start_time ?: $default_clinic_start;
                $clinic_end = $weekly_schedule->end_time ?: $default_clinic_end;
            }
            $lunch_start = $weekly_schedule->lunch_start;
            $lunch_end = $weekly_schedule->lunch_end;
        }

        // -----------------------------
        // 2. APPLY DATE OVERRIDES
        // -----------------------------
        $date_override = DateOverride::where('date', $input_dt)->first();
        if ($date_override) {
            if ($date_override->is_closed) {
                $clinic_start = null;
                $clinic_end = null;
                $is_closed = true;
            } else {
                $clinic_start = $date_override->custom_start_time ?: $clinic_start;
                $clinic_end = $date_override->custom_end_time ?: $clinic_end;
                $is_closed = false;
            }
        }

        // If clinic is closed, no slots available
        if ($is_closed) {
            $allSlots = $clinic_default_timings;
            $blocked_slots = $clinic_default_timings;
        } else {
            // Generate time slots based on clinic hours
            $clinic_end_exclusive = date('H:i', strtotime($clinic_end) - ($setting->duration * 60));
            $allSlots = generateTimeSlots(date('H:i', strtotime($clinic_start)), $clinic_end_exclusive);
            $blocked_slots = [];
        }

        // -----------------------------
        // 3. GET BLOCKED TIME RANGES
        // -----------------------------
        
        $lunch_slots = [];
        $is_day_blocked = false;

        // Add lunch time slots if they exist
        if ($lunch_start && $lunch_end && !$is_closed) {
            $lunch_end_exclusive = date('H:i', strtotime($lunch_end) - ($setting->duration * 60));
            $lunch_slots_array = generateTimeSlots(date('H:i', strtotime($lunch_start)), $lunch_end_exclusive);
            $lunch_slots = array_merge($lunch_slots, $lunch_slots_array);
        }

        // Get block time ranges that apply to this date
        $block_ranges = BlockTimeRange::where(function($query) use ($input_dt, $dayNumber) {

            // =====================================================
            // WEEKLY BLOCK WITH DATE RANGE
            // =====================================================
            $query->where(function($q) use ($input_dt, $dayNumber) {

                $q->where('type', 'weekly')
                ->where('day_of_week', $dayNumber)

                // IMPORTANT
                ->where(function($dateQuery) use ($input_dt) {

                    // no date restriction (forever weekly)
                    $dateQuery->whereNull('start_date')
                                ->whereNull('end_date')

                    // OR date range restriction
                    ->orWhere(function($rangeQuery) use ($input_dt) {

                        $rangeQuery->whereDate('start_date', '<=', $input_dt)
                                    ->whereDate('end_date', '>=', $input_dt);
                    });
                });
            })

            // =====================================================
            // EXACT DATE BLOCK
            // =====================================================
            ->orWhere(function($q) use ($input_dt) {

                $q->where('type', 'date')
                ->whereDate('start_date', $input_dt);
            })

            // =====================================================
            // RANGE BLOCK
            // =====================================================
            ->orWhere(function($q) use ($input_dt) {

                $q->where('type', 'range')
                ->whereDate('start_date', '<=', $input_dt)
                ->whereDate('end_date', '>=', $input_dt);
            });

        })->get();

        if($block_ranges->isNotEmpty()) {
            foreach ($block_ranges as $block) {
                if ($block->is_full_day) {
                    // Block entire day
                    $blocked_slots = array_merge($blocked_slots, $clinic_default_timings);
                    $is_day_blocked = true;
                } else {
                    // Block specific time range
                    $block_slots = generateTimeSlots(
                        date('H:i', strtotime($block->start_time)),
                        date('H:i', strtotime($block->end_time))
                    );
                    $blocked_slots = array_merge($blocked_slots, $block_slots);
                }
            }
        }

        // Remove duplicates
        $blocked_slots = array_unique($blocked_slots);
        $lunch_slots = array_unique($lunch_slots);

        // -----------------------------
        // 4. GET EXISTING BOOKINGS
        // -----------------------------
        $bookings = Booking::where('booking_date', $input_dt)
            ->whereNotIn('booking_status', ['canceled','declined'])
            ->pluck('time_slots')
            ->flatMap(fn($s) => explode(',', $s))
            ->toArray();

        // -----------------------------
        // 5. GET CURRENT BOOKING SLOTS (if editing)
        // -----------------------------
        $current_booking_slot = [];
        if(isset($data['booking_status']) && ($data['booking_status'] == 'pending' || $data['booking_status'] == 'confirmed') && isset($data['cbooking_id'])) {
            $current_booking_slot = Booking::where('id', $data['cbooking_id'])->where('booking_date', $input_dt)
            ->pluck('time_slots')
            ->flatMap(fn ($s) => explode(',', $s))
            ->toArray();
        }

        // Remove current booking slots from booked slots
        $bookings = array_values(array_diff($bookings, $current_booking_slot));

        // -----------------------------
        // 6. GENERATE SLOT HTML WITH COLORS
        // -----------------------------
        $slot_html = '';
        $block_type = $is_day_blocked ? 'Day is blocked' : '';
        foreach ($allSlots as $slot) {
            $isLunch = in_array($slot, $lunch_slots);
            $isBlocked = in_array($slot, $blocked_slots);
            $isBooked = in_array($slot, $bookings);
            $isCurrentBooked = in_array($slot, $current_booking_slot);

            if ($isBooked) {
                $class = 'slot_brd disable_slots engaged';
                $title = 'Already Booked By Others';
            } elseif ($isBlocked) {
                $class = 'slot_brd blocked_slot'; // Admin can still select blocked slots
                $title = $is_day_blocked ? 'Day is blocked (Admin can book)' : 'Blocked Time (Admin can book)';
            } elseif ($isLunch) {
                $class = 'slot_brd lunch_slot';
                $title = 'Lunch Time';
            } 
            elseif($isCurrentBooked) {
                $class = "slot_brd disable_slots engaged";
                $title = "Current Booking";
            }
            else {
                $class = 'slot_brd';
                // $style = '';
                $title = 'Available';
            }

            $slot_html .= '
                <div class="col-md-4 col-sm-6 mt-3">
                    <div class="btn '.$class.' bg-white text-body text-uppercase p-2 w-100"
                        data-value="'.$slot.'"
                        data-duration="'.$required_duration.'"
                        data-other-booked="'.($isBooked ? 1 : 0).'"
                        data-current-booked="'.($isCurrentBooked ? 1 : 0).'"
                        data-blocked="'.($isBlocked ? 1 : 0).'"
                        data-lunch="'.($isLunch ? 1 : 0).'"
                        title="'.$title.'">
                        '.$slot.'
                    </div>
                </div>';
        }

        return response()->json([
            'status' => 200,
            'message' => $slot_html,
            'duration' => $required_duration,
            'block_type' => $block_type,
            'cli_endtm' => $clinic_end
        ]);
    }


    // Save Appointment Here
    public function save(Request $request)
    {
        // pr($request->toArray()); die;
        $setting = getSetting();
        // Fresh comfirm booking in booking table.
        $validated = $request->validate([
            'customer_id'    => 'required',
            'therapist_id'   => 'required',
            'customer_name'  => 'required|string|max:50',
            'customer_email' => 'required|email|max:100',
            'customer_mobile'=> 'required|string|max:10',
            'message'        => 'nullable|string|max:150',
            'services'       => 'required|array|min:1',
            'services.*'     => 'exists:services,id',
            'slots'          => 'required|array|min:1',
            'slots.*'        => 'string',
            'appoint_dt'     => 'required|date',
            'total_price'    => 'required|numeric|min:1'
        ]);

        try {
            $booking = new Booking;
            if($request->action == 'send_form') {
                $booking->booking_status = 'pending';
            }
            elseif($request->action == 'confirm') {
                $booking->booking_status = 'confirmed';
            }
            // pr($validated['slots']);die;
            $booking->service_provider_id = $request->therapist_id;
            $booking->customer_id = $validated['customer_id'];
            $booking->customer_name = $validated['customer_name'];
            $booking->customer_email = $validated['customer_email'];
            $booking->customer_mobile = $validated['customer_mobile'];
            $booking->message = $validated['message'] ?? '';;
            $booking->services = implode(',', $validated['services']);
            $booking->time_slots = implode(',', $validated['slots']);
            $booking->booking_date = get_formatted_date($validated['appoint_dt'], 'Y-m-d');
            $booking->total_amount = $validated['total_price'];
                        
            $booking->save();

            // Mail Sending to customer of Booking.
            // Convert service IDs to names
            $serviceIds = explode(',', $booking->services);
            $serviceNames = Service::whereIn('id', $serviceIds)->pluck('service_name')->toArray();

            $parent_ids = Service::whereIn('id', $serviceIds)->pluck('parent_id')->toArray();
            $duration = Service::whereIn('id', $serviceIds)->pluck('duration')->toArray();
            $parent_servicename = Service::whereIn('id', $parent_ids)->pluck('service_name')->toArray();

            $booking->service_names = implode(', ', $serviceNames); // Add this temporary property for use in the email

            $booking->parent_service_name = implode(',', $parent_servicename);
            $booking->parent_ids = $parent_ids;
            $booking->duration = $duration;
            
            // save the encrpted booking id in booking table
            $encrypted_customer_id = Crypt::encryptString($validated['customer_id']);
            Booking::where('id', $booking->id)->update(['encrypted_id' => $encrypted_customer_id]);
            
            if($setting->global_mail == 1) {
                if($request->action == 'send_form') {
                    $medical_form_link = route('medical_form', $encrypted_customer_id);
                    Mail::to($booking->customer_email)->send(new sendMedicalFormMail($booking->customer_name, $medical_form_link));
                }
                if($request->action == 'confirm') {
                    $medical_form_link = route('medical_form', $encrypted_customer_id);
                    Mail::to($booking->customer_email)->send(new AppointmentStatusConfirmedMail($booking, $medical_form_link));
                }
            }

            // send sms for confirmed Booking
            if($request->action == 'confirm') {
                $objTwilio = new TwilioService();
                if($booking->parent_ids[0] == 1) {
                    $ser = 'RMT Massage Therapy';
                }
                else {
                    $ser = $booking->parent_service_name;
                }
                $lastspace = strpos($booking->customer_name, ' ');
                $first_name = substr($booking->customer_name, 0, $lastspace);
                $message = 'Hello '.ucwords($first_name).', your appointment at Divine Touch Therapy for '.$ser.' on '.get_formatted_date($booking->booking_date, 'F d, Y').' at '.explode(',', $booking->time_slots)[0].' is confirmed. Please inform us of any changes at least 24 hours before your appointment time via email or call to the clinic. This number cannot receive text replies. Thanks!';
                $objTwilio->sendSms($booking->customer_mobile, $message);
            }
            
            return response()->json(['status' => 200, 'message' => 'Your Appointment is Booked Sucessfully!']);
        }
        catch(Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Something went wrong. Please try again later. '.$e->getMessage()]);
        }
    }

    /**
     * Show the Appointment Detail for edit the Appointment.
    */
    public function edit($id)
    {
        // get Appointment Detail
        $result = Booking::findOrFail($id);

        // get Service Provider
        $all_providers = ServiceProvider::where('status', 1)->get(['id', 'first_name', 'last_name', 'license']);

        $serviceids = explode(',', $result->services);
        // Get all selected service duration with name and price.
        $services = Service::whereIn('id', $serviceids)->get(['id', 'duration']);

        $required_duration = $services->sum('duration');
        // End Here
        $main_services = Service::where('status', '1')->where('parent_id', 0)->get(); // Parent Service Name
        $sub_service = Service::where('status', '1')->where('parent_id', '<>', 0)->get(); // Childs of Service Name
        if($main_services)
        {
            $all_services = array();
            foreach($main_services as $val) {
                $j = 0;
                foreach($sub_service as $service) {
                    if($val->id == $service->parent_id) {
                        $all_services[$val->service_name][$j]['id'] = $service->id;
                        $all_services[$val->service_name][$j]['service_name'] = $service->service_name;
                        $all_services[$val->service_name][$j]['duration'] = $service->duration;
                        $all_services[$val->service_name][$j]['price'] = $service->price;
                    }
                    $j++;
                }
            }
        }

        // Slot availability logic similar to checkAvailability
        $setting = getSetting();
        $input_dt = $result->booking_date;
        $dayNumber = date('N', strtotime($input_dt)); // 1=Monday, 7=Sunday

        // Default Clinic Timings
        $default_clinic_start = $setting->start_time;
        $default_clinic_end = $setting->end_time;

        // clinic default open time slots
        $clinic_default_timings = generateTimeSlots(date('H:i', strtotime($default_clinic_start)), date('H:i', strtotime($default_clinic_end)), $setting->duration);

        // -----------------------------
        // 1. GET WEEKLY SCHEDULE
        // -----------------------------
        $weekly_schedule = WeeklySchedule::where('day_of_week', $dayNumber)->first();

        if (!$weekly_schedule) {
            // If no weekly schedule exists, use default clinic times
            $clinic_start = $default_clinic_start;
            $clinic_end = $default_clinic_end;
            $is_closed = false;
            $lunch_start = null;
            $lunch_end = null;
        } else {
            $is_closed = $weekly_schedule->is_closed == 1;
            if ($is_closed) {
                $clinic_start = null;
                $clinic_end = null;
            } else {
                $clinic_start = $weekly_schedule->start_time ?: $default_clinic_start;
                $clinic_end = $weekly_schedule->end_time ?: $default_clinic_end;
            }
            $lunch_start = $weekly_schedule->lunch_start;
            $lunch_end = $weekly_schedule->lunch_end;
        }

        // -----------------------------
        // 2. APPLY DATE OVERRIDES
        // -----------------------------
        $date_override = DateOverride::where('date', $input_dt)->first();
        if ($date_override) {
            if ($date_override->is_closed) {
                $clinic_start = null;
                $clinic_end = null;
                $is_closed = true;
            } else {
                $clinic_start = $date_override->custom_start_time ?: $clinic_start;
                $clinic_end = $date_override->custom_end_time ?: $clinic_end;
                $is_closed = false;
            }
        }

        // If clinic is closed, no slots available
        if ($is_closed) {
            $allSlots = $clinic_default_timings;
        } else {
            // Generate time slots based on clinic hours
            $allSlots = generateTimeSlots(date('H:i', strtotime($clinic_start)), date('H:i', strtotime($clinic_end)));
        }

        // -----------------------------
        // 3. GET BLOCKED TIME RANGES
        // -----------------------------
        $blocked_slots = [];
        $lunch_slots = [];
        $is_day_blocked = false;

        // Add lunch time slots if they exist
        if ($lunch_start && $lunch_end && !$is_closed) {
            $lunch_slots_array = generateTimeSlots(date('H:i', strtotime($lunch_start)), date('H:i', strtotime($lunch_end)));
            $lunch_slots = array_merge($lunch_slots, $lunch_slots_array);
        }

        // Get block time ranges that apply to this date
        $block_ranges = BlockTimeRange::where(function($query) use ($input_dt, $dayNumber) {
            $query->where('type', 'weekly')
                  ->where('day_of_week', $dayNumber)
            ->orWhere(function($q) use ($input_dt) {
                $q->where('type', 'date')
                  ->where('start_date', $input_dt);
            })
            ->orWhere(function($q) use ($input_dt) {
                $q->where('type', 'range')
                  ->where('start_date', '<=', $input_dt)
                  ->where('end_date', '>=', $input_dt);
            });
        })->get();

        foreach ($block_ranges as $block) {
            if ($block->is_full_day) {
                // Block entire day
                $blocked_slots = array_merge($blocked_slots, $clinic_default_timings);
                $is_day_blocked = true;
            } else {
                // Block specific time range
                $block_slots = generateTimeSlots(
                    date('H:i', strtotime($block->start_time)),
                    date('H:i', strtotime($block->end_time))
                );
                $blocked_slots = array_merge($blocked_slots, $block_slots);
            }
        }

        // Remove duplicates
        $blocked_slots = array_unique($blocked_slots);
        $lunch_slots = array_unique($lunch_slots);

        // -----------------------------
        // 4. GET All EXISTING BOOKINGS on Date
        // -----------------------------
        $bookings = Booking::where('booking_date', $input_dt)
            ->whereNotIn('booking_status', ['canceled','declined'])
            ->pluck('time_slots')
            ->flatMap(fn($s) => explode(',', $s))
            ->toArray();

        // -----------------------------
        // 5. GET CURRENT BOOKING SLOTS (exclude current booking)
        // -----------------------------
        $current_booking_slot = explode(',', $result->time_slots);
        $bookings = array_values(array_diff($bookings, $current_booking_slot)); // Other Bookings

        // -----------------------------
        // 6. GENERATE SLOT DATA
        // -----------------------------
        $all_slots_str = implode(',', $allSlots);
        $blocked_slots_str = implode(',', $blocked_slots);
        $lunch_slots_str = implode(',', $lunch_slots);
        $other_booked_str = implode(',', $bookings);
        $current_slots_str = implode(',', $current_booking_slot);

        return view('admin.appointment.edit', compact('all_services','result', 'all_slots_str', 'blocked_slots_str', 'lunch_slots_str', 'other_booked_str', 'current_slots_str', 'required_duration','all_providers'));
    }

    public function update(Request $request)
    {
        // pr($request->toArray()); die;
        $setting = getSetting();
        // Fresh comfirm booking in booking table.
        $validated = $request->validate([
            'customer_id'    => 'required',
            'therapist_id'   => 'required',
            'customer_name'  => 'required|string|max:50',
            'customer_email' => 'required|email|max:100',
            'customer_mobile'=> 'required|string|max:10',
            'message'        => 'nullable|string|max:150',
            'services'       => 'required|array|min:1',
            'services.*'     => 'exists:services,id',
            'slots'          => 'nullable|array|min:1',
            'slots.*'        => 'string',
            'appoint_dt'     => 'required|date',
            'total_price'    => 'required|numeric|min:1'
        ]);

        try {
            $booking = Booking::findOrFail($request->id);
            $booking->booking_status = $request['booking_status'];
            $booking->service_provider_id = $request['therapist_id'];
            $booking->customer_id = $validated['customer_id'];
            $booking->customer_name = $validated['customer_name'];
            $booking->customer_email = $validated['customer_email'];
            $booking->customer_mobile = $validated['customer_mobile'];
            $booking->message = $validated['message'] ?? '';

            $changed_services = implode(',', $validated['services']);
            if($changed_services !== $booking->services && empty($validated['slots'])){
                return response()->json([
                    'status' => 422,
                    'message' => 'Please select time slots after changing services.'
                ]);
            }
            $booking->services = $changed_services;
            if(!empty($validated['slots'])) {
                $booking->time_slots = implode(',', $validated['slots']);
            }
            
            $booking->booking_date = get_formatted_date($validated['appoint_dt'], 'Y-m-d');
            $booking->total_amount = $validated['total_price'];
            
            $booking->save();

            // Mail Sending to customer of Booking.
            // Convert service IDs to names
            $serviceIds = explode(',', $booking->services);
            $serviceNames = Service::whereIn('id', $serviceIds)->pluck('service_name')->toArray();
            $parent_ids = Service::whereIn('id', $serviceIds)->pluck('parent_id')->toArray();
            $duration = Service::whereIn('id', $serviceIds)->pluck('duration')->toArray();
            $booking->service_names = implode(', ', $serviceNames); // Add this temporary property for use in the email
            $booking->parent_ids = $parent_ids;
            $booking->duration = $duration;
            $parent_servicename = Service::whereIn('id', $parent_ids)->pluck('service_name')->toArray();
            $parent_service_name = implode(',', $parent_servicename);
            $booking->parent_service_name = $parent_service_name;
            // Mail::to($validated['customer_email'])->send(new RescheduleAppointmentMail($booking));

            // SMS send for update booking.
            $lastspace = strpos($booking->customer_name, ' ');
            $first_name = substr($booking->customer_name, 0, $lastspace);
            if($parent_ids[0] == 1) {
                $ser = 'RMT Massage Therapy';
            }
            else {
                $ser = $parent_service_name;
            }

            if($request['booking_status'] == 'confirmed') {
                if($setting->global_mail == 1) {
                    Mail::to($validated['customer_email'])->send(new RescheduleAppointmentMail($booking));
                }
                $sms_message = 'Hello '.ucwords($first_name).', your appointment with Divine Touch Therapy for '.$ser.' has been rescheduled to '.get_formatted_date($validated['appoint_dt'], 'F d, Y').' at '.explode(',', $booking->time_slots)[0].'. Please inform us of any changes at least 24 hours before your appointment time via email or call to the clinic. This number cannot receive text replies. Thanks!';
            }
            if($request['booking_status'] == 'canceled') {
                $sms_message = 'Hello '.ucwords($first_name).', Your appointment at Divine Touch Therapy for '.$ser.' on '.get_formatted_date($validated['appoint_dt'], 'F d, Y').' at '.explode(',', $booking->time_slots)[0].' has been cancelled as per your request. Please let us know if you have any query or concern via email or call to the clinic. This number cannot receive text replies. Thanks!';
            }
            if($request['booking_status'] == 'declined') {
                $sms_message = 'Hello '.ucwords($first_name).', We regret to inform that your appointment request for '.$ser.' on '.get_formatted_date($booking->booking_date, 'F d, Y').' at '.explode(',', $booking->time_slots)[0].' at Divine Touch Therapy has been declined. Please retry your appointment some other date/time, or reach out to us via email or call to the clinic. This number cannot receive text replies. Thanks!';
            }
            if($setting->global_sms == 1) {
                $objTwilio = new TwilioService();
                $objTwilio->sendSms($booking->customer_mobile, $sms_message);
            }
            return response()->json(['status' => 200, 'message' => 'Appointment is Updated Sucessfully!']);
        }
        catch(Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Something went wrong. Please try again later. '.$e->getMessage()]);
        }
    }

    public function delete($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete(); // soft delete

        return response()->json([
            'status' => true,
            'message' => 'Appointment deleted successfully'
        ]);
    }

    // List Past Appointments
    public function pastAppointments()
    {
        return view('admin.appointment.past_appointments');
    }

    // Show listing of past Appointments
    public function pastAppointmentList(Request $request)
    {
        if ($request->ajax()) {
            $bookings = Booking::with('customer')
            ->leftJoin('users', 'users.id', '=', 'bookings.customer_id')
            ->select('bookings.*')
            ->addSelect('users.last_name as sort_last_name');

            // Apply status filter if provided
            if ($request->has('status') && !empty($request->status)) {
                $bookings->where('booking_status', $request->status);
            }

            if($request->app_st && $request->app_ed) {
                $bookings->whereBetween('booking_date', [
                    get_formatted_date($request->app_st, 'Y-m-d'),
                    get_formatted_date($request->app_ed, 'Y-m-d')
                ]);
            }
            elseif($request->app_st) {
                $bookings->whereDate('booking_date', '>=', $request->get_formatted_date($request->app_st, 'Y-m-d'));
            }
            elseif($request->app_ed) {
                $bookings->whereDate('booking_date', '<=', $request->get_formatted_date($request->app_ed, 'Y-m-d'));
            }
            else {
                $bookings->whereDate('booking_date', '<', date('Y-m-d'));
            }

            return DataTables::of($bookings)
                ->addIndexColumn()
                ->addColumn('customer_name', function ($booking) {
                    $first = $booking->customer->first_name ?? '';
                    $last = $booking->customer->last_name ?? '';
                    if(empty($last)) {
                        $name = trim($first);
                    }
                    else {
                        $name = trim("$last, $first");
                    }
                    
                    $profile_link = route('admin.userprofile', $booking->customer_id);
                    return '<div><a href="'.$profile_link.'" class="text-decoration-none" data-bs-toggletip="tooltip" data-bs-title="'.$name.', '.$booking->customer_mobile.', '.$booking->customer_email.'">' . ucwords($name) . '</a></div>';
                })
                ->addColumn('date_time', function ($booking) {
                    $starting_slot = explode(',', $booking->time_slots);
                    return get_formatted_date($booking->booking_date, 'M d, Y') . '<br> ' . $starting_slot[0];
                })
                ->addColumn('duration', function ($booking){
                    $duration = 30;
                    $slots = explode(',', $booking->time_slots);
                    return $duration * count($slots);
                })
                ->addColumn('services', function ($booking) {
                    $serviceIds = explode(',', $booking->services);
                    $serviceNames = Service::whereIn('id', $serviceIds)->pluck('service_name')->toArray();
                    return implode(', ', $serviceNames);
                })
                ->addColumn('status', function ($booking) {
                    $status = strtolower($booking->booking_status);
                    $badges = [
                        'confirmed' => 'primary',
                        'completed' => 'success',
                        'canceled'  => 'danger',
                        'pending'   => 'warning',
                    ];
                    $color = $badges[$status] ?? 'secondary';

                    return '<div><span class="badge text-bg-' . $color . '">' . ucfirst($status) . '</span></div>';
                })
                ->addColumn('action', function($booking){
                    $editAppointment = route('admin.edit_appointment', $booking->id);
                    $rebookAppointment = route('admin.add.appointment', $booking->id);

                    $updateStatus = "updateAppointmentStatus(this, '".$booking->id."')";
                    $viewDetail = "viewBookingDetail('".$booking->id."')";
                    $deleteAppointment = "deleteAppointment('".$booking->id."')";
                    $sendMedicalForm = "sendMedicalForm('".$booking->customer_id."')";
                    $create_invoice = route('admin.invoice_form', $booking->id);
                    $genrate_soap_note = route('admin.generate_soapnote', $booking->id);
                    $delete_action = '<li><a class="dropdown-item" href="javascript:void(0);" onclick="'.$deleteAppointment.'"><i class="bi bi-trash"></i> Delete</a></li>';
                        if($booking->booking_status == 'declined' || $booking->booking_status == 'canceled') {
                            $edit_action = '';
                            $cancel_action = '';
                            $decline_action = '';
                            $create_inv = '';
                            $send_medical_form = '';
                            $generate_soap_note = '';
                            $confirm_action = '<li><a class="dropdown-item" href="'.$rebookAppointment.'" data-value="rebook"><i class="bi bi-check-lg text-info"></i> Re-Book</a></li>';
                        }    
                        else {
                            $edit_action = '<li><a class="dropdown-item" href="'.$editAppointment.'"><i class="bi bi-pencil"></i> Edit</a></li>';
                            $confirm_action = '<li><a class="dropdown-item" href="javascript:void(0);" onclick="'.$updateStatus.'" data-value="confirmed"><i class="bi bi-check-lg text-info"></i> Confirm</a></li>';

                            $cancel_action = '<li><a class="dropdown-item" href="javascript:void(0);" onclick="'.$updateStatus.'" data-value="canceled"><i class="bi bi-x-lg text-danger"></i> Cancel</a></li>';
                            $decline_action = '<li><a class="dropdown-item" href="javascript:void(0);" onclick="'.$updateStatus.'" data-value="declined"><i class="bi bi-ban text-danger"></i> Decline</a></li>';

                            $create_inv = '<li><a id="inv_'.$booking->id.'" class="dropdown-item" href="'.$create_invoice.'"><div class="d-none" id="div_inv_'.$booking->id.'" style="width:0.8rem; height:0.8rem;"></div><i class="bi bi-receipt" id="inv_'.$booking->id.'"></i> Create Invoice</a></li>';
                            $send_medical_form = '<li><a id="a_'.$booking->id.'" class="dropdown-item" href="javascript:void(0);" onclick="'.$sendMedicalForm.'"><div class="d-none" id="sp_smf_'.$booking->id.'" style="width:0.8rem; height:0.8rem;"></div><i class="bi bi-send-arrow-up" id="i_'.$booking->id.'"></i> Send Medical Form</a></li>';
                            $generate_soap_note = '<li><a class="dropdown-item" href="'.$genrate_soap_note.'"><div class="d-none" style="width:0.8rem; height:0.8rem;"></div><i class="bi bi-node-plus" id="soap_'.$booking->id.'"></i> Generate SOAP Notes</a></li>';
                        }

                        if($booking->booking_status == 'completed') {
                            $edit_action = '';
                            $confirm_action = '';
                            $cancel_action = '';
                            $decline_action = '';
                            $create_inv = '';
                            $send_medical_form = '';
                            $generate_soap_note = '';
                        }
                    $action = '<div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu" style="">
                                    
                                    '.$edit_action.'
                                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="'.$viewDetail.'" data-bs-toggle="modal" data-bs-target="#appointmentDetailPop" data-bs-whatever="appointmentDetailPop"><i class="bi bi-binoculars"></i> View</a></li>

                                    '.$create_inv.'
                                    
                                    '.$send_medical_form.'

                                    '.$generate_soap_note.$delete_action.'
                                </ul>
                            </div>';
                    return $action;
                })
                
                ->orderColumn('customer_name', function ($query, $order) {
                    $query->orderBy('sort_last_name', $order);
                })
                ->orderColumn('date_time', function ($query, $order) {
                    $setorder = 'asc';
                    $query
                        ->orderBy('bookings.booking_date', $order)
                        ->orderByRaw("
                            STR_TO_DATE(
                                SUBSTRING_INDEX(bookings.time_slots, ',', 1),
                                '%h:%i%p'
                            ) {$setorder}
                        ");
                })
                
                ->filterColumn('customer_name', function($query, $keyword) {
                    $query->whereHas('customer', function($q) use ($keyword) {
                        $q->where('first_name', 'like', "%{$keyword}%")
                        ->orWhere('last_name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('services', function($query, $keyword) {
                    $query->whereRaw("EXISTS (
                        SELECT 1 FROM services 
                        WHERE FIND_IN_SET(services.id, bookings.services) 
                        AND services.service_name LIKE ?
                    )", ["%{$keyword}%"]);
                })
                
                ->rawColumns(['customer_name','services', 'date_time', 'duration', 'status', 'action']) // in case of <br> or HTML in future
                ->make(true);
        }
    }
}
