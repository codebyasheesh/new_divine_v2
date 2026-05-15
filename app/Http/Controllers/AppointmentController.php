<?php

namespace App\Http\Controllers;

use App\Mail\NewBookingNotification;
use App\Models\BlockTimeRange;
use App\Models\Service;
use App\Models\Booking;
use App\Models\DateOverride;
use App\Models\HolidayList;
use App\Models\ServiceProvider;
use App\Models\User;
use App\Services\TwilioService;
use App\Models\WeeklySchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use function Psy\debug;

class AppointmentController extends Controller
{
    public function index()
    {
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
        $provider = ServiceProvider::where('status', 1)->first(['id', 'first_name', 'last_name']);

        return view('frontend.book_appointment', compact('all_services', 'provider'));
    }

    public function checkearlydateforbooking(Request $request)
    {
        $service = $request->services;
        $data = Service::whereIn('id', $service)->get(['id', 'service_name', 'duration']);
        if($data->isNotEmpty())
        {
            $req_duration = 0;
            foreach($data as $val){
                $req_duration += $val->duration;
            }
        }
        if($request->offset == 0) {
            // Get the date from Current date to next 20 days except sunday
            $curr_date = date('Y-m-d');
            $last_date = date('Y-m-t');
        }
        else {
            if($request->offset == 1 ){
                $curr_date = date('Y-m-d', strtotime('first day of next month'));
                $last_date = date('Y-m-d', strtotime('last day of next month'));
            }
            elseif($request->offset > 1) {
                $curr_date = date('Y-m-d', strtotime('first day of +'.$request->offset.' months'));
                $last_date = date('Y-m-t', strtotime('last day of +'.$request->offset.' months'));
            }
        }
        // echo $curr_date;echo '<br>';
        // echo $last_date;die;
        
        while($curr_date <= $last_date) {
            if(date('w', strtotime($curr_date)) == 0) {
                // $dat_arr[] = $curr_date;
                $curr_date = date('Y-m-d', strtotime($curr_date . ' +1 day'));
                continue;
            }
            $curr_mon = date('F', strtotime($curr_date));

            $dayNumber = date('w', strtotime($curr_date));
            // default Block Slots
            if ($dayNumber >= 1 && $dayNumber <= 5) {
                // Monday–Friday
                $default_block_slots = ['02:00pm','02:30pm','03:00pm','03:30pm'];
            }
            elseif ($dayNumber == 6) {
                // Saturday
                $default_block_slots = array_merge(
                    ['09:30am'],
                    generateTimeSlots('15:30', '19:00')
                );
            }
            
            $morningSlots = generateTimeSlots('09:30', '13:30');
            $no_slot_av = generateTimeSlots('14:00', '15:30');
            $eveningSlots = generateTimeSlots('16:00', '19:00');
            $allSlots = array_merge($morningSlots, $no_slot_av, $eveningSlots);

            // -----------------------------
            // HOLIDAY CHECK
            // -----------------------------
            $blk_tm_slt = [];
            $getHolidays = HolidayList::whereDate('start', '<=', $curr_date)->whereDate('end', '>=', $curr_date)->first();
            if($getHolidays) {
                $blk_tm_slt = $allSlots;
                $block_msg = $getHolidays->holiday_name;
                $holiday_rang = $getHolidays->holiday_range;
            }
            else {
                $blk_tm_slt = [];
                $dayname = getDayName(date('N', strtotime($curr_date)));
                $getBlockData = DB::table('block_dates')->whereRaw('FIND_IN_SET(?, block_date)', [$curr_date])->where('day', $dayname)->get();

                foreach($getBlockData as $val) {
                    $blk_tm_slt[] = $val->time_slot; // Block time on Selected Date.
                }
            }

            // -----------------------------
            // BOOKINGS
            // -----------------------------
            $bookings = Booking::where('booking_date', $curr_date)
                ->whereNotIn('booking_status', ['canceled','declined'])
                ->pluck('time_slots')
                ->flatMap(fn($s) => explode(',', $s))
                ->toArray();

            // $remaining_slots = [];
            $unavailableSlots = array_unique(array_merge(
                $default_block_slots ?? [], 
                $blk_tm_slt ?? [],
                $bookings ?? []
            ));
            $freeslots = array_values(array_diff($allSlots, $unavailableSlots));
            $slotInterval = 30;    // minutes
            $requiredSlots = ceil($req_duration / $slotInterval); // ceil gives the upward round digit.

            $availableSlots = [];
            foreach ($freeslots as $index => $slot) {

                if ($this->hasContinuousSlots($freeslots, $index, $requiredSlots)) {
                    $availableSlots[] = $slot; // valid start slot
                    return response()->json(['status' => true, 'early_date' => $curr_date, 'freeslots' => $availableSlots]);
                }
            }
            $curr_date = date('Y-m-d', strtotime($curr_date . ' +1 day'));
               
        }
        return response()->json([
            'status'  => false,
            'message' => 'There are currently no timeslots available for your selected service in '.$curr_mon
        ]);
    }

    private function hasContinuousSlots(array $slots, int $startIndex, int $requiredSlots)
    {
        for($i = 0; $i < $requiredSlots - 1; $i++) {
            if(!isset($slots[$startIndex + $i + 1])) {
                return false;
            }

            $current = strtotime($slots[$startIndex + $i]);
            $next = strtotime($slots[$startIndex + $i + 1]);

            if(($next - $current) !== 1800) {
                return false;
            }
        }
        return true;
    }

    /**
    * Method: checkAvailability
     * 
     * Description: This function is used to check the availability of time slots based on selected services and date. It calculates the total duration of the selected services and checks against existing bookings for the specified date.
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAvailability() 
    {
        $setting = getSetting();
        $data = request()->all();
        $service_ids = $data['services'];
        
        // Get all selected service duration with name and price.
        $services = Service::whereIn('id', $service_ids)->get(['id','service_name', 'price', 'duration']);

        $required_duration = $services->sum('duration');
        
        $selected_date = get_formatted_date($data['appoint_dt'], 'Y-m-d');
        $dayNumber = date('N', strtotime($selected_date)); // 1=Monday, 7=Sunday

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
        $date_override = DateOverride::where('date', $selected_date)->first();
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
        $block_ranges = BlockTimeRange::where(function($query) use ($selected_date, $dayNumber) {

            // =====================================================
            // WEEKLY BLOCK WITH DATE RANGE
            // =====================================================
            $query->where(function($q) use ($selected_date, $dayNumber) {

                $q->where('type', 'weekly')
                ->where('day_of_week', $dayNumber)

                // IMPORTANT
                ->where(function($dateQuery) use ($selected_date) {

                    // no date restriction (forever weekly)
                    $dateQuery->whereNull('start_date')
                                ->whereNull('end_date')

                    // OR date range restriction
                    ->orWhere(function($rangeQuery) use ($selected_date) {

                        $rangeQuery->whereDate('start_date', '<=', $selected_date)
                                    ->whereDate('end_date', '>=', $selected_date);
                    });
                });
            })

            // =====================================================
            // EXACT DATE BLOCK
            // =====================================================
            ->orWhere(function($q) use ($selected_date) {

                $q->where('type', 'date')
                ->whereDate('start_date', $selected_date);
            })

            // =====================================================
            // RANGE BLOCK
            // =====================================================
            ->orWhere(function($q) use ($selected_date) {

                $q->where('type', 'range')
                ->whereDate('start_date', '<=', $selected_date)
                ->whereDate('end_date', '>=', $selected_date);
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
        $bookings = Booking::where('booking_date', $selected_date)
            ->whereNotIn('booking_status', ['canceled','declined'])
            ->pluck('time_slots')
            ->flatMap(fn($s) => explode(',', $s))
            ->toArray();
        
        // get selected service duration
        
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
                $class = 'slot_brd blocked_slot';
                $title = 'Lunch Time';
            } else {
                $class = 'slot_brd';
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
        
        return response()->json(['status' => 200, 'message' => $slot_html, 'duration' => $required_duration, 'block_type' => $block_type, 'block_range' => '','cli_endtm' => date('H:i', strtotime($clinic_end))]);
    }

    public function processBooking(Request $request) {
        // Validate the incoming request data. For booking in wait list booking Table.
        // Fresh comfirm booking in booking table.
        $validated = $request->validate([
            'customer_id'    => 'required',
            'customer_name'  => 'required|string|max:50',
            'customer_email' => 'required|email|max:100',
            'customer_mobile'=> 'required|regex:/^[0-9]{3}[-\s]?[0-9]{3}[-\s]?[0-9]{4}$/',
            'message'        => 'nullable|string|max:150',
            'services'       => 'required|array|min:1',
            'services.*'     => 'exists:services,id',
            'slots'          => 'required|array|min:1',
            'slots.*'        => 'string',
            'appoint_dt'     => 'required|date',
            'total_price'    => 'required|numeric|min:1',
        ]);
        
        // if(!empty($request->))
        $booking = new Booking;
        $booking->booking_status = 'pending';
        // $booking->payment_mode = $validated['payment_method'];


        $request->merge([
            'customer_mobile' => str_replace([' ','-'], '', $request['customer_mobile'])
        ]);
        
        $slotDuration = 30;
        // Count selected slots
        $selectedSlots = $validated['slots']; // array
        $totalSlotMinutes = count($selectedSlots) * $slotDuration;

        $serviceDuration = Service::whereIn('id', $validated['services'])->sum('duration');

        if($totalSlotMinutes < $serviceDuration) {
            return response()->json([
                'status' => 422,
                'message' => "Selected timeslot does not allow sufficient time for your selected service. Please select another suitable timeslot."
            ]);
        }
        $provider = ServiceProvider::where('status', 1)->first(['id']);
        $booking->customer_id = $validated['customer_id'];
        $booking->service_provider_id = $provider->id;
        $booking->customer_name = ucwords($validated['customer_name']);
        $booking->customer_email = $validated['customer_email'];
        $booking->customer_mobile = $request['customer_mobile'];
        $booking->message = $validated['message'] ?? '';;
        $booking->services = implode(',', $validated['services']);
        $booking->time_slots = implode(',', $validated['slots']);
        $booking->booking_date = $validated['appoint_dt'];
        $booking->total_amount = $validated['total_price'];
        
        // Add Google Captcha Validation
        if(!empty($request->token))
        {
            $secretKey = '6LenkgwrAAAAADFjBfq0gFVqZ3pGa8o8OyfxpKgI';
            // Google reCAPTCHA verification API Request  
            $api_url = 'https://www.google.com/recaptcha/api/siteverify';  
            $resq_data = array(  
                'secret' => $secretKey,
                'response' => $request->token,
                'remoteip' => $_SERVER['REMOTE_ADDR']  
            );

            $curlConfig = array(  
                CURLOPT_URL => $api_url,  
                CURLOPT_POST => true,  
                CURLOPT_RETURNTRANSFER => true,  
                CURLOPT_POSTFIELDS => $resq_data  
            );

            $ch = curl_init();  
            curl_setopt_array($ch, $curlConfig);  
            $response = curl_exec($ch);  
            unset($ch);  

            // Decode JSON data of API response in array  
            $responseData = json_decode($response);
            if(!$responseData->success) {
                $setting = getSetting();
                $booking->save();
                if($booking->id) {
                    // Save encrypted Booking id
                    $encrypted_booking_id = Crypt::encryptString($booking->id);
                    Booking::where('id', $booking->id)->update(['encrypted_id' => $encrypted_booking_id]);
                    // Mail Sending to customer of Booking.
                    // Convert service IDs to names
                    $serviceIds = explode(',', $booking->services);
                    $serviceNames = Service::whereIn('id', $serviceIds)->pluck('service_name')->toArray();
                    $booking->service_names = implode(', ', $serviceNames); // Add this temporary property for use in the email

                    // Send mail to admin

                    if($setting->global_mail == 1) {
                        Mail::to('bookings@divinetouchtherapy.com')->send(new NewBookingNotification($booking));
                    }
                        
                    return response()->json(['status' => 200, 'message' => 'Your appointment request has been successfully received!']);
                    // End Mail sending...
                }
                else {
                    return response()->json(['status' => 500, 'message' => 'Something went wrong. Please try again later.']);
                }
            }
            else {
                return response()->json(['status' => 500, 'message' => 'captcha Validation Fail']);
            }
        }
    }

    public function getRegisterDetail(Request $request) {
        $request->merge([
            'mobile' => str_replace([' ','-'], '', $request->mobile)
        ]);
        $request->validate([
            'f_name'  => 'required|string',
            'l_name'  => 'required|string',
            'email'   => 'required|email',
            'mobile'  => 'required|digits:10'
        ]);

        $firstName = trim($request->f_name);
        $lastName  = trim($request->l_name);
        $email     = trim($request->email);
        $mobile    = trim($request->mobile);

        if(!empty($request->token)) {
            $secretKey = '6LenkgwrAAAAADFjBfq0gFVqZ3pGa8o8OyfxpKgI';
            // Google reCAPTCHA verification API Request  
            $api_url = 'https://www.google.com/recaptcha/api/siteverify';  
            $resq_data = array(  
                'secret' => $secretKey,
                'response' => $request->token,  
                'remoteip' => $_SERVER['REMOTE_ADDR']  
            );

            $curlConfig = array(  
                CURLOPT_URL => $api_url,  
                CURLOPT_POST => true,  
                CURLOPT_RETURNTRANSFER => true,  
                CURLOPT_POSTFIELDS => $resq_data  
            );
            
            $ch = curl_init();  
            curl_setopt_array($ch, $curlConfig);  
            $response = curl_exec($ch);  
            unset($ch);  

            // Decode JSON data of API response in array  
            $responseData = json_decode($response);
            if(!$responseData->success) {
                /**
                 * Step 1: Check if SAME user already exists
                 */
                $exactUser = User::where('email', $email)
                    ->where('mobile', $mobile)
                    ->where('first_name', $firstName)
                    ->where('last_name', $lastName)
                    ->first();

                if ($exactUser) {
                    return response()->json([
                        'status'  => 200,
                        'msg' => 'existing_user',
                        'user_id' => $exactUser->id,
                        'customer_mobile' => $mobile,
                        'customer_email' => $email,
                        'customer_first_name' => $firstName,
                        'customer_last_name' => $lastName
                    ], 200);
                }

                /**
                 * Check the First name and last name
                 */
                $checkDependentUser = User::where('first_name', $firstName)
                    ->where('last_name', $lastName)
                    ->first();
                
                $checkParentUser = User::where('email', $email)->where('mobile', $mobile)->first();
                
                if(($checkDependentUser) && ($checkParentUser)) {
                    if(($checkDependentUser->family_id == $checkParentUser->family_id) && ($checkParentUser->family_id > 0)) {
                        return response()->json([
                            'status'=> 200,
                            'msg' => 'dependent_exist', 
                            'user_id' => $checkDependentUser->id,
                            'customer_mobile' => $mobile,
                            'customer_email' => $email,
                            'customer_first_name' => $firstName,
                            'customer_last_name' => $lastName
                        ], 200);
                    }
                }
                else if(empty($checkDependentUser) && !empty($checkParentUser)) {
                    /**
                     * Step 2: Create a dependent with existing email and mobile number
                     */
                        // Determine family_id
                    if (!$checkParentUser->family_id || $checkParentUser->family_id == 0) {
                        $familyId = $this->getLastUsedFamilyId();
                        if(!empty($familyId)) {
                            $new_family_id = $familyId + 1;
                        }
                            
                        // Update primary user with new family_id
                        User::where('id', $checkParentUser->id)->update([
                            'family_id' => $new_family_id,
                        ]);
                    }
                    else {
                        $new_family_id = $checkParentUser->family_id;
                    }

                    // Create family member WITHOUT email & mobile
                    $user = new User();
                    $user->first_name = ucwords($firstName);
                    $user->last_name = ucwords($lastName);
                    $user->email = null;
                    $user->mobile = null;
                    if(!empty($request->gender)) {
                        $user->gender = $request->gender;
                    }
                    if(!empty($request->dob_y) && !empty($request->dob_m) && !empty($request->dob_d)) {
                        $user->dob = get_formatted_date($request->dob_y.'-'.$request->dob_m.'-'.$request->dob_d, 'Y-m-d');
                    }
                    $user->family_id = $new_family_id;
                    $user->dependent = 'yes';
                    $user->save();

                    return response()->json([
                        'status'  => 200,
                        'msg' => 'family_member_created',
                        'user_id' => $user->id,
                        'customer_mobile' => $mobile,
                        'customer_email' => $email,
                        'customer_first_name' => $firstName,
                        'customer_last_name' => $lastName
                    ], 201);
                }
                else if(!empty($checkDependentUser) && empty($checkParentUser)) {
                    /*** First and Last name exist and email and mobile not exist then create new Record with entered email and mobile number ***/
                    /*** First name, Last name, email match but mobile does not match case  ***/
                    // Get parent email and mobile
                    $get_pnt_detail = User::where('family_id', $checkDependentUser->family_id)->whereNotNull('family_id')->get(['email','mobile']);

                    if($get_pnt_detail->isNotEmpty()) {
                        $e_flag = false;
                        $m_flag = false;
                        foreach($get_pnt_detail as $val) {
                            if($val->email == $email) {
                                $e_flag = true;
                                break;
                            }
                        }
                        foreach($get_pnt_detail as $val) {
                            if($val->mobile == $mobile) {
                                $m_flag = true;
                                break;
                            }
                        }
                        
                        if($m_flag == false) {
                            // New Mobile number added in inputbox. Now check dependent mobile available or not. if available then enter in alternate field else in mobile field
                            $deped_mob = User::where('id', $checkDependentUser->id)->first(['mobile']);
                            if(empty($deped_mob->mobile)) {
                                // add mobile in dependent row
                                $checkuniq = User::where('mobile', $mobile)->first();
                                if(empty($checkuniq)) {
                                    User::where('id', $checkDependentUser->id)->update(['mobile' => $mobile]);
                                    return response()->json([
                                        'status'  => 200,
                                        'msg' => 'new_mobile',
                                        'user_id' => $checkDependentUser->id,
                                        'customer_mobile' => $mobile,
                                        'customer_email' => $email,
                                        'customer_first_name' => $firstName,
                                        'customer_last_name' => $lastName
                                    ]);
                                }
                                else {
                                    return response()->json([
                                        'status'  => 400,
                                        'msg' => 'Please use unique mobile number to proceed. '.$mobile.' is already associated with a user.',
                                    ]);
                                }
                                
                            }
                            else {
                                // add mobile in dependent row
                                $checkuniq = User::where('mobile', $mobile)->first();
                                if(empty($checkuniq)) {
                                    User::where('id', $checkDependentUser->id)->update(['alternate_mobile' => $mobile]);

                                    return response()->json([
                                        'status'  => 200,
                                        'msg' => 'new_altername_mobile',
                                        'user_id' => $checkDependentUser->id,
                                        'customer_mobile' => $mobile,
                                        'customer_email' => $email,
                                        'customer_first_name' => $firstName,
                                        'customer_last_name' => $lastName
                                    ]);
                                }
                                else {
                                    return response()->json([
                                        'status'  => 400,
                                        'msg' => 'Please use unique mobile number to proceed. '.$mobile.' is already associated with a user.',
                                    ]);
                                }
                                
                            }
                        }
                        else {
                            return response()->json([
                                'status'  => 200,
                                'msg' => 'family_mobile_exist',
                                'user_id' => $checkDependentUser->id,
                                'customer_mobile' => $mobile,
                                'customer_email' => $email,
                                'customer_first_name' => $firstName,
                                'customer_last_name' => $lastName
                            ]);
                        }
                    }
                    else {
                        die('No');
                    }
                    
                    /*$mobilemismatch = User::where('email', $email)
                        ->where('first_name', $firstName)
                        ->where('last_name', $lastName)
                        ->first();

                    if($mobilemismatch) {
                        // check mobile number exist in his family or not
                        if($mobilemismatch->family_id > 0) {
                            $check_fam_mob = User::where('family_id', $mobilemismatch->family_id)->where('mobile', $mobile)->first();
                            if(!empty($check_fam_mob)) {
                                // No Need to enter mobile number in alternate field
                                return response()->json([
                                    'status'  => 200,
                                    'msg' => 'mobile_mismatch',
                                    'user_id' => $mobilemismatch->id,
                                    'customer_mobile' => $mobile,
                                    'customer_email' => $email,
                                    'customer_first_name' => $firstName,
                                    'customer_last_name' => $lastName
                                ], 200);
                            }
                            else {
                                if(!empty($mobilemismatch->mobile)) {
                                    User::where('id', $mobilemismatch->id)->update(['alternate_mobile' => $mobile]);
                                }
                                else {
                                    User::where('id', $mobilemismatch->id)->update(['mobile' => $mobile]);
                                }
                                
                                return response()->json([
                                    'status'  => 200,
                                    'msg' => 'mobile_mismatch',
                                    'user_id' => $mobilemismatch->id,
                                    'customer_mobile' => $mobile,
                                    'customer_email' => $email,
                                    'customer_first_name' => $firstName,
                                    'customer_last_name' => $lastName
                                ], 200);
                            }
                        }
                        else {
                            if(!empty($mobilemismatch->mobile)) {
                                User::where('id', $mobilemismatch->id)->update(['alternate_mobile' => $mobile]);
                            }
                            else {
                                User::where('id', $mobilemismatch->id)->update(['mobile' => $mobile]);
                            }
                        }
                        return response()->json([
                            'status'  => 200,
                            'msg' => 'mobile_mismatch',
                            'user_id' => $mobilemismatch->id,
                            'customer_mobile' => $mobile,
                            'customer_email' => $email,
                            'customer_first_name' => $firstName,
                            'customer_last_name' => $lastName
                        ], 200);
                    }
                    else {
                        // Check the mobile
                        $mobilecheck = User::where('mobile', $mobile)->first();
                        if($mobilecheck && $mobilecheck->family_id > 0) {
                            User::where('family_id', $mobilecheck->family_id)->where('id', $checkDependentUser->id)->update(['email' => $email]);
                            return response()->json([
                                'status'  => 200,
                                'msg' => 'add_emailid_in_dependent',
                                'user_id' => $checkDependentUser->id,
                                'customer_mobile' => $mobile,
                                'customer_email' => $email,
                                'customer_first_name' => $firstName,
                                'customer_last_name' => $lastName
                            ], 200);
                        }
                    }

                    $emailmismatch = User::where('mobile', $mobile)
                    ->where('first_name', $firstName)
                    ->where('last_name', $lastName)
                    ->first();
                    if(!empty($emailmismatch)) {
                        // check email exist in his family or not
                        if($emailmismatch->family_id > 0) {
                            $check_fam_email = User::where('family_id', $emailmismatch->family_id)->where('email', $email)->first();
                            if(empty($check_fam_email)) {
                                // Add new email number into another field in users table
                                User::where('id', $emailmismatch->id)->update(['email' => $email]);
                                return response()->json([
                                    'status'  => 200,
                                    'msg' => 'email_mismatch_empty',
                                    'user_id' => $emailmismatch->id,
                                    'customer_mobile' => $mobile,
                                    'customer_email' => $email,
                                    'customer_first_name' => $firstName,
                                    'customer_last_name' => $lastName
                                ], 200);
                            }
                            else {
                                return response()->json([
                                    'status'  => 200,
                                    'msg' => 'email_mismatch',
                                    'user_id' => $emailmismatch->id,
                                    'customer_mobile' => $mobile,
                                    'customer_email' => $email,
                                    'customer_first_name' => $firstName,
                                    'customer_last_name' => $lastName
                                ], 200);
                            }
                        }
                        else {
                            // update email into email field in users table
                            User::where('id', $emailmismatch->id)->update(['email' => $email]);
                            return response()->json([
                                'status'  => 200,
                                'msg' => 'email_mismatch',
                                'user_id' => $emailmismatch->id,
                                'customer_mobile' => $mobile,
                                'customer_email' => $email,
                                'customer_first_name' => $firstName,
                                'customer_last_name' => $lastName
                            ], 200);
                        }
                    }
                    else {
                        die('email mismatch else');
                    }*/
                }
                else if(empty($checkDependentUser) && empty($checkParentUser))
                {
                    // If first name, last name and mobile not match and email exist
                    if(session('otp_verified') == true) {
                        $user = new User();
                        $user->first_name = ucwords($firstName);
                        $user->last_name = ucwords($lastName);
                        $user->email = $email;
                        $user->mobile = $mobile;
                        if(!empty($request->gender)) {
                            $user->gender = $request->gender;
                        }
                        $user->family_id = 0;
                        $user->is_primary = 1;
                        $user->password = Hash::make($mobile);
                        $chk_fam_id = User::where('email', $email)->first(['family_id']);
                        if(isset($chk_fam_id) && $chk_fam_id->family_id > 0) {
                            $user->family_id = $chk_fam_id->family_id;
                            $user->email = null;
                            $user->password = null;
                            $user->is_primary = 0;
                        }

                        
                        if(!empty($request->dob_y) && !empty($request->dob_m) && !empty($request->dob_d)) {
                            $user->dob = get_formatted_date($request->dob_y.'-'.$request->dob_m.'-'.$request->dob_d, 'Y-m-d');
                        }
                        
                        $user->save();
                        // after save record remove the otp status 
                        session()->forget(['otp_verified']);

                        return response()->json([
                            'status'  => 200,
                            'msg' => 'new_user_created',
                            'user_id' => $user->id,
                            'customer_mobile' => $mobile,
                            'customer_email' => $email,
                            'customer_first_name' => $firstName,
                            'customer_last_name' => $lastName
                        ], 201);
                    }
                    else {
                        return response()->json(['status' => 401, 'msg' => 'Email OTP not Verified, Please try in previous screen']);
                    }
                }
                /**
                 * Last Check: If First Name, Last Name, email and mobile does not match in record then create fresh new Entry.
                 */
                
                
            }
            else {
                return response()->json(['status' => 400, 'msg' => 'Captcha Validation Failed'], 400);
            }
        }
        
    }

    public function validateEmail(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email'
        ]);
        $email = $request->email;

        // Check existing OTP session
        $existingEmail = session('otp_email');
        $expiresAt = session('otp_expires_at');
        $verified = session('otp_verified');
        $verfied_email = session('otp_email');
        // session(['otp_verified' => false]);
        if($verified == true && $verfied_email == $email) {
            $user = User::where('email', $email)->first();
            if($user->family_id == 0) {
                return response()->json([
                    'status' => false,
                    'type' => 'single_user',
                    'user' => $user,
                    'message' => 'OTP already verified'
                ]);
            }
            elseif($user->family_id > 0) {
                $members = User::where('family_id', $user->family_id)
                ->get(['id','first_name','last_name','email','mobile','gender','dob']);

                return response()->json([
                    'status' => false,
                    'type' => 'family_users',
                    'members' => $members,
                    'message' => 'OTP already verified'
                ]);
            }
        }

        // If same email and OTP still valid → block resend
        if ($existingEmail === $email && $expiresAt && now()->lt($expiresAt) && !$verified ) {
            return response()->json([
                'status' => true,
                'email_exists' => session('user_id') ? true : false,
                'family_id' => session('family_id'),
                'message' => 'OTP already sent and not expired. Please use it before expire.'
            ]);
        }

        // Email changed OR OTP expired → generate new
        $user = User::where('email', $email)->first();
        
        // Generate OTP
        $otp = generateOtp();

        session([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
            'otp_verified' => false,
            'otp_email' => $email,
            'user_id' => $user ? $user->id : null,
            'family_id' => $user ? $user->family_id : null
        ]);

        $otp_txt = "Your OTP is {$otp}. It is valid for 5 minutes.";
        $mailSent = false;
        try{
            Mail::raw(
                $otp_txt,
                function ($mail) use ($email) {
                    $mail->to($email)
                        ->subject('Email Verification OTP');
                }
            );
            $mailSent = true;
        }
        catch(\Throwable $e){
            // Catch EVERYTHING (Exception + Error)
            Log::error('Mail sending error: ' . $e->getMessage());
        }

        if($user && $mailSent) {
            return response()->json([
                'status' => true,
                'email_exists' => $user ? true : false,
                'family_id' => $user ? $user->family_id : null,
                'mail_sent' => $mailSent, // true
                'message' => 'OTP sent to your email'
            ]);
        }
        else if($user && !$mailSent) {
            // In this case ask to client to send OTP on their registered Mobile number
            $mobForOtp = !empty($user->mobile) ? $user->mobile : $user->alternate_mobile;

            // 2. Check if we still don't have a number and have a family_id
            if (empty($mobForOtp) && $user->family_id > 0) {
                $parent = User::where('family_id', $user->family_id)
                    ->whereNotNull('mobile')
                    ->where('mobile', '!=', '')
                    ->first();

                // 3. Use the null-safe operator (?->) to prevent crashes
                $mobForOtp = $parent?->mobile ?? $parent?->alternate_mobile;
            }
            return response()->json([
                'status' => false,
                'email_exists' => $user ? true : false,
                'family_id' => $user ? $user->family_id : null,
                'mail_sent' => $mailSent,
                'mobuse' => $mobForOtp,
                'message' => 'mail could not sent and ask to client send OTP in sms'
            ]);
        }
        else if(!$user && $mailSent) {
            return response()->json([
                'status' => false,
                'email_exists' => false,
                'family_id' => null,
                'mail_sent' => $mailSent, // true
                'message' => 'client not registered and mail sent'
            ]);
        }
        elseif(!$user && !$mailSent) {
            return response()->json([
                'status' => false,
                'email_exists' => false,
                'family_id' => null,
                'mail_sent' => false,
                'sms_sent' => false,
                'message' => 'We apologize that your email address could not be validated by our system. Please contact our clinic for further assistance with your booking.'
            ]);
        }
    }

    public function sendOtpOnMobile(Request $request)
    {
        $mobile = $request->mobile;
        $otp = generateOtp();
        $otp_txt = "Your OTP is {$otp}. It is valid for 5 minutes.";
        session([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
            'otp_verified' => false,
            'otp_mobile' => $mobile,
            'user_id' => null,
            'family_id' => null
        ]);

        try{
            $objTwilio = new TwilioService();
            $objTwilio->sendSms($mobile, $otp_txt);

            return response()->json([
                'status' => true,
                'mobile' => $mobile,
                'message' => 'OTP sent on mobile'
            ]);
        }
        catch(\Throwable $e) {
            // Catch EVERYTHING (Exception + Error)
            Log::error('SMS sending error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Unable to send OTP'
            ]);
        }
    }

    public function checkemailotp(Request $request)
    {
        if (!session()->has('otp_code')) {
            return response()->json([
                'status' => false,
                'message' => 'OTP expired. Please resend.'
            ]);
        }

        if (now()->greaterThan(session('otp_expires_at'))) {
            session()->forget(['otp_code', 'otp_expires_at']);
            return response()->json([
                'status' => false,
                'message' => 'OTP expired'
            ]);
        }

        if ($request->otp == session('otp_code')) {
            session()->forget(['otp_code', 'otp_expires_at']);
            session(['otp_verified' => true]);

            $userId = session('user_id');
            $familyId = session('family_id');

            // New Email entered
            if (!$userId) {
                return response()->json([
                    'status' => true,
                    'type' => 'new_user',
                    'message' => 'OTP verified successfully'
                ]);
            }

            // CASE 2: Existing user & family_id = 0
            if ($familyId == 0) {
                $user = User::find($userId);

                return response()->json([
                    'status' => true,
                    'type' => 'single_user',
                    'user' => $user,
                    'message' => 'OTP verified successfully'
                ]);
            }

            // CASE 3: family_id > 0
            $members = User::where('family_id', $familyId)
                ->get(['id','first_name','last_name','email','mobile','gender','dob']);

            return response()->json([
                'status' => true,
                'type' => 'family_users',
                'members' => $members,
                'message' => 'OTP verified successfully'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid OTP'
        ]);
    }

    private function getLastUsedFamilyId() 
    {
        $data = DB::table('users')->where('role', '<>', 'admin')->where('family_id', '<>', 'NULL')->groupBy('family_id')->orderBy('family_id', 'DESC')->limit(1)->pluck('family_id');   
        if(isset($data[0])) {
            return $data[0];
        }
        else {
            return false;
        }
        
    }
}
