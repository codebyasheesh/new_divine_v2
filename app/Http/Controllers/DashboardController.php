<?php

namespace App\Http\Controllers;

use App\Mail\AddIndividualInFamilyRequest;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use App\Models\WaitlistBooking;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    /**
     * Show the Dashboard of logged-in User
     */
    public function index()
    {
        $loggedin_customer = User::where('id', Auth::user()->id)->first(['id', 'family_id','first_name', 'last_name', 'email','mobile', 'address', 'city', 'state', 'postal_code', 'dob', 'soap_note_link'])->toArray();
        // pr($loggedin_customer); die;
        $family_members = [];
        if(!empty($loggedin_customer['family_id'])) {
            $family_members = User::where('family_id', $loggedin_customer['family_id'])->where('id', '<>', $loggedin_customer['id'])->get(['id', 'family_id','first_name', 'last_name','email','mobile', 'address', 'city', 'state', 'postal_code', 'dob', 'soap_note_link'])->toArray();
        }
        
        // pr($family_members); die;
        $fml_id = '';
        $all_fml_id = '';
        if(!empty($family_members)) {
            foreach($family_members as $val) {
                $fml_id .= $val['id'].',';
            }
            $fml_id = rtrim($fml_id, ',');
            $fml_id = $loggedin_customer['id'].','.$fml_id;
            $all_fml_id = explode(',', $fml_id);
        }
        else {
            $all_fml_id = array($loggedin_customer['id']);
            $fml_id = $loggedin_customer['id'];
        }
        
        // pr($all_fml_id);die;
        // All Family members including loggedin user
        $all_members = array_merge($loggedin_customer, $family_members);

        // get Confirmed Booking count
        $confirmed_bookings = Booking::whereIn('customer_id', $all_fml_id)->where('booking_status', 'confirmed')->count();
        
        // Get Pending Booking count
        $pending_bookings = Booking::whereIn('customer_id', $all_fml_id)->where('booking_status', 'pending')->count();
        // Get Completed Booking Count
        $completed_bookings = Booking::whereIn('customer_id', $all_fml_id)->where('booking_status', 'completed')->count();

        // Get Canceled Booking Count
        $canceled_bookings = Booking::whereIn('customer_id', $all_fml_id)->where('booking_status', 'canceled')->count();

        // Decline Bookings
        $declined_bookings = Booking::whereIn('customer_id', $all_fml_id)->where('booking_status', 'declined')->count();

        // $wait_bookings = WaitlistBooking::whereIn('customer_id', $all_fml_id)->where('status', 'pending')->count();
        
        $data = array(
            'all_members' => $all_members,
            'confirm_booking_count' => $confirmed_bookings,
            'pending_booking_count' => $pending_bookings,
            'completed_booking_count' => $completed_bookings,
            'canceled_booking_count' => $canceled_bookings,
            'decline_booking_count' => $declined_bookings,
            'family_ids' => $fml_id
        );
        // pr($data); die;
        return view('frontend.dashboard', compact('data'));
    }

    public function bookingListAjax(Request $request)
    {
        // pr($request->all());
        $booking_status = $request['status'];
        $family_ids = $request['family_id'];
        
        $all_ids = explode(',', $family_ids);

        // get Confirmed Booking count
        if($booking_status != 'waitlist') {
            $confirmed_bookings = Booking::where('booking_status', $booking_status)->whereIn('customer_id', $all_ids)->get()->toArray();
            if(!empty($confirmed_bookings)) {
                
                $bookings = [];
                foreach($confirmed_bookings as $key => $val) {
                    $service_name = '';
                    $bookings[$key]['id'] = $val['id'];
                    $bookings[$key]['customer_name'] = $val['customer_name'];
                    $bookings[$key]['customer_email'] = $val['customer_email'];
                    $bookings[$key]['customer_mobile'] = $val['customer_mobile'];
                    $bookings[$key]['booking_date'] = get_formatted_date($val['booking_date']);
                    $bookings[$key]['time_slots'] = $val['time_slots'];
                    $bookings[$key]['total_amount'] = $val['total_amount'];
                    $bookings[$key]['message'] = $val['message'];
                    $bookings[$key]['booking_status'] = $val['booking_status'];
                    // $bookings[$key]['payment_status'] = $val['payment_status'];
                    // $bookings[$key]['payment_mode'] = $val['payment_mode'];

                    // Get Services Names
                    $serviceid = explode(',', $val['services']);
                    $service_detail = Service::whereIn('id', $serviceid)->get(['id','service_name'])->toArray();
                    
                    foreach($service_detail as $val2) {
                        $service_name .= $val2['service_name'].', ';
                    }
                    $service_name = rtrim($service_name, ', ');
                    $bookings[$key]['service_name'] = $service_name;
                }

                if($bookings) {
                    $trtddesign = '';
                    foreach($bookings as $val) {
                        $canelBooking = "cancelBooking('".$val['id']."', '')";
                        $reSchedule = "cancelBooking('".$val['id']."', 'reschedule')";
                        $cancel_href = '';
                        if($val['booking_status'] == 'pending' || $val['booking_status'] == 'confirmed') {
                            $cancel_href = '<a href="javascript:void(0);" onclick="'.$canelBooking.'" class="btn btn-danger me-2"><i class="fas fa-times"></i> Cancel</a> <a href="javascript:void(0);" class="btn btn-outline-primary" onclick="'.$reSchedule.'"><i class="fas fa-reply"></i> Re-Schedule</a>';
                        }

                        $trtddesign .= '<tr class="border-bottom"><td class="text-primary p-3 fs-6">'.$val['id'].'</td><td class="p-3">'.$val['booking_date'].'<br>'.$val['time_slots'].'</td><td class="p-3">'.$val['service_name'].'</td><td class="p-3"><div class="row"><div class="col-lg-12"><strong>Customer Name: </strong>'.ucwords($val['customer_name']).'</div><div class="col-lg-12"><strong>Mobile: </strong>'.$val['customer_mobile'].'</div><div class="col-lg-12"><strong>Email: </strong>'.$val['customer_email'].'</div></div></td><td class="p-3">$'.$val['total_amount'].'</td><td class="text-primary p-3 fs-6">'.$cancel_href.'</td></tr>';
                    }
                }
                return response()->json(['status'=> 200, 'message' => $trtddesign]);
            }
            else {
                $trtddesign = '<tr class="border-bottom"><td class="text-primary p-3 fs-6" colspan="5">Record Not Found</td></tr>';
                return response()->json(['status'=> 200, 'message' => $trtddesign]);
            }
        }
        else {
            $waitBookings = WaitlistBooking::whereIn('customer_id', $all_ids)->whereTodayOrAfter('booking_date')->get()->toArray();
            if(!empty($waitBookings)) {
                $service_name = '';
                $bookings = [];
                foreach($waitBookings as $key => $val) {
                    $bookings[$key]['id'] = $val['id'];
                    $bookings[$key]['customer_id'] = $val['customer_id'];
                    $bookings[$key]['customer_name'] = $val['customer_name'];
                    $bookings[$key]['customer_email'] = $val['customer_email'];
                    $bookings[$key]['customer_mobile'] = $val['customer_mobile'];
                    
                    $bookings[$key]['booking_date'] = $val['booking_date'];
                    $bookings[$key]['time_slots'] = $val['time_slots'];
                    $bookings[$key]['total_amount'] = $val['total_amount'];
                    $bookings[$key]['message'] = $val['message'];
                    $bookings[$key]['status'] = $val['status'];

                    $serviceid = explode(',', $val['services']);
                    $service_detail = Service::whereIn('id', $serviceid)->get(['id','service_name'])->toArray();
                    
                    foreach($service_detail as $val2) {
                        $service_name .= $val2['service_name'].', ';
                    }
                    $service_name = rtrim($service_name, ', ');
                    $bookings[$key]['service_name'] = $service_name;

                }
                // pr($bookings);die;
                if($bookings) {
                    $trtddesign = '';
                    foreach($bookings as $val) {
                        if($val['status'] == 'pending') {
                            $completeUrl = route('waited_booking');
                            $action = '<a href="'.$completeUrl.'" class="btn btn-primary"><i class="fas fa-book-open-reader"></i> Complete Booking</a>';
                        }
                        else {
                            $completeUrl = '';
                            $action = '<span class="badge rounded-pill text-bg-success">Completed</span>';
                        }
                        
                        $trtddesign .= '<tr class="border-bottom"><td class="text-primary p-3 fs-6">'.$val['id'].'</td><td class="p-3">'.$val['booking_date'].'<br>'.$val['time_slots'].'</td><td class="p-3">'.$val['service_name'].'</td><td class="p-3"><div class="row"><div class="col-lg-12"><strong>Customer Name: </strong>'.ucwords($val['customer_name']).'</div><div class="col-lg-12"><strong>Mobile: </strong>'.$val['customer_mobile'].'</div><div class="col-lg-12"><strong>Email: </strong>'.$val['customer_email'].'</div></div></td><td class="p-3">$'.$val['total_amount'].'</td><td class="text-primary p-3 fs-6">'.$action.'</td></tr>';
                    }
                    
                }
                else {
                    $trtddesign = '<tr class="border-bottom"><td class="text-primary p-3 fs-6" colspan="5">Record Not Found</td></tr>';
                }
                return response()->json(['status'=> 200, 'message' => $trtddesign]);
            }
            else {
                $trtddesign = '<tr class="border-bottom"><td class="text-primary p-3 fs-6" colspan="5">Record Not Found</td></tr>';
                return response()->json(['status'=> 200, 'message' => $trtddesign]);
            }
        }
    }

    /**
     * Show Family members List
     */
    public function familyMembersByAjax(Request $request)
    {
        $loggedin_customer = User::where('id', Auth::user()->id)->get(['id', 'family_id','first_name', 'last_name','email','mobile', 'dob', 'address', 'city', 'state', 'postal_code', 'soap_note_link'])->toArray();
        // pr($loggedin_customer->toArray()); die;
        $family_members = [];
        if($loggedin_customer[0]['family_id'] > 0) {
            $family_members = User::where('family_id', $loggedin_customer[0]['family_id'])->where('id', '<>', $loggedin_customer[0]['id'])->get(['id', 'family_id','first_name', 'last_name','email','mobile', 'dob', 'address', 'city', 'state', 'postal_code', 'soap_note_link'])->toArray();
        }
        // pr($family_members); die;

        // All Family members including loggedin user
        $all_members = array_merge($loggedin_customer, $family_members);
        if(!empty($all_members)) {
            $fam_htm = '';
            foreach($all_members as $val) {
                $full_name = ($val['last_name']) ? $val['first_name'].' '.$val['last_name'] : $val['first_name'];
                 $fam_htm .= '<tr class="border-bottom">
                                        <td class="text-primary p-3 fs-6">'.ucwords($full_name).'</td>
                                        <td class="p-3">'.$val['email'].'</td>
                                        <td class="p-3">'.$val['mobile'].'</td>
                                        <td class="text-primary p-3 fs-6">
                                            <a href="javascript:void(0);" class="btn btn-primary btn-sm me-2" title="View Detail"><i class="fas fa-eye"></i> View</a>
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#memberDeletePopup" data-bs-whatever="memberDeletePopup" title="Make Delete Request to Admin"><i class="fas fa-trash"></i> Delete</a>
                                        </td>
                                    </tr>';
            }
            return response()->json(['status' => 200, 'output' => $fam_htm]);
        }
    }

    /**
     * Account Detail by Ajax Request
     */
    public function accountDetailByAjax()
    {
        $loggedin_customer = User::where('id', Auth::user()->id)->first(['id','first_name','last_name','email','mobile','gender','dob','city','state','postal_code', 'address'])->toArray();
        // pr($loggedin_customer); die;
        return response()->json(['status' => 200, 'output' => $loggedin_customer]);
    }

    public function updateAccountDetailByAjax(Request $request)
    {
        // echo pr($request->all());die;
        $validator = Validator::make($request->all(), [
            'acc_first_name' => 'required',
            'acc_last_name' => 'required',
            'acc_email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(Auth::id()),
            ],
            'acc_mobile' => [
                'required',
                'regex:/^[0-9]{3}[-\s]?[0-9]{3}[-\s]?[0-9]{4}$/',
                Rule::unique('users', 'mobile')->ignore(Auth::id()),
            ],
            'acc_gender' => 'required'
        ]);

        if($validator->passes()) {
            user::where('id', Auth::user()->id)->update([
                'first_name' => $request->acc_first_name,
                'last_name' => $request->acc_last_name,
                'email' => $request->acc_email,
                'mobile' => $request->acc_mobile,
                'gender' => $request->acc_gender,
                'city' => $request->acc_city,
                'state' => $request->acc_state,
                'address' => $request->acc_address,
                'postal_code' => $request->acc_postal_code
            ]);
            return response()->json(['status' => 200, 'message' => 'Detail updated Successfully']);
        }
        else {
            return response()->json(['status' => 400, 'message' => 'Oops, something went wrong, '.$validator]);
        }
    }

    public function addMemberByAjax (Request $request) 
    {
        try{
            $rules = [
                'first_name' => [
                    'required',
                    'regex:/^[A-Za-z]+(?:\s[A-Za-z]+){0,2}$/', // 1–3 words, only letters & spaces
                ],
                'last_name' => [
                    'required',
                    'regex:/^[A-Za-z]+$/', // only one word, alphabets only
                ],
                'email' => [
                    'nullable',
                    'email',
                    'unique:users,email', // unique globally
                ],
                'mobile' => [
                    'nullable',
                    'regex:/^[0-9]{3}[-\s]?[0-9]{3}[-\s]?[0-9]{4}$/', // 10 digits with optional space/dash
                    'unique:users,mobile', // unique globally
                ],
            ];

            if($request->dependent === 'no') {
                $rules['email'][] = 'required';
                $rules['mobile'][] = 'required';
            }

            $request->validate($rules);

            // check family id
            $result = User::where('id', $request['parent_id'])->first();
            $familyid = $this->getLastUsedFamilyId();
            if(!empty($familyid)) {
                $next_familyid = $familyid + 1;
                if(empty($result->family_id)) {
                    User::where('id', $request['parent_id'])->update(['family_id'=> $next_familyid]);    // update first user family id.
                    $familyid = $next_familyid;
                }
                else {
                    $familyid = $result->family_id;
                }
            }
            else {
                $familyid = 1;
                User::where('id', $request['parent_id'])->update(['family_id' => $familyid]);
            }
            // Normalize the mobile number
            $request->merge([
                'mobile' => str_replace([' ','-'], '', $request['mobile'])
            ]);
            
            $user = new User();
            $user->family_id = $familyid;  // Logged in user Id
            $user->first_name = $request['first_name'];
            $user->last_name = $request['last_name'];
            $user->email = $request['email'];
            $user->mobile = $request['mobile'];
            $user->gender = $request['gender'];
            $user->city = $request['city'];
            $user->state = $request['state'];
            $user->postal_code = $request['postal_code'];
            $user->address = $request['address'];
            $user->dob = get_formatted_date($request['dob'], 'Y-m-d');
            $user->dependent = $request['dependent'];
            $user->remark = $request['remark'];
            $dat = $user->save();
            return response()->json(['status' => true, 'message' => 'Family Member added Successfully'], 201);
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
        
    }

    public function cancelBookingByAjax(Request $request)
    {
        try {
            $booking_id = $request->booking_id;
            Booking::where('id', $booking_id)->update(['booking_status' => 'canceled']);
            return response()->json(['status' => true, 'message' => 'Appointment Canceled Successfully.'], 200);
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Booking Could not be canceled due to some Server Error: '.$e->getMessage()], 500);
        }
        


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

    /**
     * Send mail to Admin for Add Individual Client Request
    */
    public function addIndividualInFamilyRequest(Request $request)
    {
        try{
            $setting = getSetting();
            $first_member_data = User::where('id', $request->parent_id)->first();
            $individual_first_name = $request->first_name; 
            $individual_last_name = $request->last_name;
            $individual_email = $request->email;
            $individual_mobile = $request->mobile;

            $final_data = array(
                'parent_first_name' => $first_member_data->first_name,
                'parent_last_name'  => $first_member_data->last_name,
                'parent_mobile'     => $first_member_data->mobile,
                'parent_email'      => $first_member_data->email,
                'indi_first_name'   => $individual_first_name,
                'indi_last_name'    => $individual_last_name,
                'indi_mobile'       => $individual_mobile,
                'indi_email'        => $individual_email
            );
            // pr($final_data); die;
            // Send Email
            $to = 'ashcool007@gmail.com';
            $bcc = 'mca.asheesh@gmail.com';
            if($setting->global_mail == 1) {
                Mail::to($to)->bcc($bcc)->send(new AddIndividualInFamilyRequest($final_data));
            }
            
            return response()->json(['status' => true, 'message' => 'Add Individual In Family Request Sent Successfully.']);
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Request could not be sent due to '.$e->getMessage()]);
        }
    }
}
