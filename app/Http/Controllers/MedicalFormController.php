<?php

namespace App\Http\Controllers;

use App\Mail\MedicalFormPdfMail;
use App\Models\Booking;
use App\Models\MedicalForm;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MedicalFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($encrypedid)
    {
        try{
            $id = Crypt::decryptString($encrypedid);
            $cust_dtl = User::where('id', $id)->first(['id', 'family_id', 'first_name', 'last_name','email','mobile','dob','address','city','state','postal_code','gender','remark']);
            $medical_data = MedicalForm::where('customer_id', $id)->first();
            $mdl_data = '';
            if($medical_data) {
                $mdl_data = $medical_data;
            }
            if(!session()->has('fom_otp_verified') || session('fom_otp_verified') !== true) {
                $this->sendOtpMail($cust_dtl);
            }
            
            // pr($mdl_data);die;
            return view('frontend.medical_form', ['customer_id' => $id, 'customer_detail' => $cust_dtl, 'mdl_data' => $mdl_data, 'otp_verified' => session('fom_otp_verified', false)]);
        }
        catch(DecryptException $e) {
            return view('frontend.errors.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // pr($request->all()); die;
        if($request->submit_form == 'first'){
            $request->merge([
                'postal_code' => str_replace(' ', '', $request->postal_code),
                'primary_phone' => str_replace([' ','-'], '', $request->primary_phone),
                'other_phone' => str_replace([' ','-'], '', $request->other_phone),
                'emergency_contact_phone' => str_replace([' ','-'], '', $request->emergency_contact_phone)
            ]);

            $request->validate(
            [
                'first_name' => 'required|string|max:40',
                'last_name' => 'required|string|max:40',
                'dob_y' => 'nullable',
                'dob_m' => 'nullable',
                'dob_d' => 'nullable',
                'gender' => 'nullable',
                'email' => 'required|string|email|max:60',
                'address' => 'required',
                'city' => 'required|max:20',
                'province' => 'required',
                'postal_code' => 'required|regex:/^[A-Za-z0-9]{3}\s?[A-Za-z0-9]{3}$/',
                'primary_phone' => 'required|regex:/^[0-9]{3}[-\s]?[0-9]{3}[-\s]?[0-9]{4}$/',
                'other_phone' => 'nullable|regex:/^[0-9]{3}[-\s]?[0-9]{3}[-\s]?[0-9]{4}$/',
                'occupation' => 'nullable|string|max:20',
                'emergency_contact_name' => 'required|string|max:40',
                'emergency_contact_phone' => 'required|regex:/^[0-9]{3}[-\s]?[0-9]{3}[-\s]?[0-9]{4}$/',
                'source_of_referral' => 'nullable|max:40',
                // Conditional required
                'extended_health_care_benefit' => 'required|in:Yes,No',
            ],
            [
                // Basic required fields
                'first_name.required' => 'Please enter your first name.',
                'first_name.max'      => 'First name may not exceed 20 characters.',

                'last_name.required' => 'Please enter your last name.',
                'last_name.max'      => 'Last name may not exceed 20 characters.',

                'gender.required' => 'Please select your gender.',

                'email.required' => 'Email address is required.',
                'email.email'    => 'Please enter a valid email address.',
                'email.max'      => 'Email address may not exceed 60 characters.',

                'address.required' => 'Please enter your complete address.',

                'city.required' => 'City is required.',
                'city.max'      => 'City name may not exceed 20 characters.',

                'province.required' => 'Please select your province.',

                // Postal & phone
                'postal_code.required' => 'Postal code is required.',
                'postal_code.regex'    => 'Please enter a valid postal code (e.g. A1A 1A1).',

                'primary_phone.required' => 'Primary phone number is required.',
                'primary_phone.regex'    => 'Please enter a valid phone number (e.g. 123-456-7890).',

                'other_phone.regex' => 'Please enter a valid alternate phone number.',

                'emergency_contact_name.required' =>
                    'Please provide an emergency contact name.',

                'emergency_contact_phone.required' =>
                    'Emergency contact phone number is required.',
                'emergency_contact_phone.regex' =>
                    'Please enter a valid emergency contact phone number.',

                // Referral & insurance
                'source_of_referral.required' =>
                    'Please specify how you were referred to us.',

                'extended_health_care_benefit.required' =>
                    'Please indicate whether you have extended health care benefits.',
            ]);
            try {
                DB::beginTransaction();

                // First Part Data Binding for save form data in table
                $data = MedicalForm::where('customer_id', $request->customer_id)->first();
                if(!$data) {
                    $data = new MedicalForm();
                }

                // $data->booking_id = $request['booking_id'];
                $data->customer_id = $request->customer_id;
                $data->first_name = $request->first_name;
                $data->middle_name = $request->middle_name;
                $data->last_name = $request->last_name;
                if(!empty($request['dob_y']) && !empty($request['dob_m']) && !empty($request['dob_d'])) {
                    $data->dob  = get_formatted_date($request['dob_y'].'-'.$request['dob_m'].'-'.$request['dob_d'], 'Y-m-d');
                }
                $data->gender = $request->gender;
                $data->pronoun = $request->pronoun;
                $data->email = $request->email;
                $data->address = $request->address;
                $data->city = $request->city;
                $data->province = $request->province;
                $data->postal_code = $request->postal_code;
                $data->primary_phone = $request->primary_phone;
                $data->other_phone = $request->other_phone;
                $data->occupation = $request->occupation;
                $data->special_accessbility_mobility = $request->special_accessibility;
                $data->emergency_contact_name = $request->emergency_contact_name;
                $data->emergency_contact_phone = $request->emergency_contact_phone;
                $data->source_of_referral = $request->source_of_referral;
                $data->extended_health_care_benefit = $request->extended_health_care_benefit;

                // update in users table if users table have no entry
                $this->updateUserDetailByMedicalFormData($request->customer_id, $request->email, $request->primary_phone, $request->dob_y, $request->dob_m, $request->dob_d, $request->gender, $request->address, $request->city, $request->province, $request->postal_code);
                $data->save();
                DB::commit();
                $customer_id = Crypt::encryptString($request->customer_id);
                return redirect()->route('medical_form', $customer_id)->with('success', 'Infomation Validated. Please click here to continue to Extended Benefits Information');
            }
            catch(Exception $e) {
                DB::rollBack();
                $customer_id = Crypt::encryptString($request->customer_id);
                return redirect()->route('medical_form', $customer_id)->withErrors('error', dd('Validation failed!', $e->getMessage()));
            }
        }

        if($request->submit_form == 'two') {
            $request->validate(
            [
                'is_primary_member' => 'required',
                'primary_member' => 'required_if:is_primary_member,No',
                'pm_dob_y' => 'required_if:is_primary_member,No',
                'pm_dob_m' => 'required_if:is_primary_member,No',
                'pm_dob_d' => 'required_if:is_primary_member,No',
                'contract_policy_plan_no' => 'required',
                'member_certificate_no' => 'required',
                'authorize_us_to_direct_bill' => 'required',
                'second_insurance_coverage' => 'required',
                'second_insu_comp_name' => 'required_if:second_insurance_coverage,Yes|max:40',
                'primary_member_name_2' => 'required_if:second_insurance_coverage,Yes|max:40',
                'pm2_dob_y' => 'required_if:second_insurance_coverage,Yes',
                'pm2_dob_m' => 'required_if:second_insurance_coverage,Yes',
                'pm2_dob_d' => 'required_if:second_insurance_coverage,Yes',
                'contract_policy_plan_no_2' => 'required_if:second_insurance_coverage,Yes',
                'member_certificate_no_2' => 'required_if:second_insurance_coverage,Yes',
            ],
            [
                // Basic required fields
                'is_primary_member.required' => 'Please specify whether you are the primary member.',
                'primary_member.required_if' => 'Primary member name is required when you are not the primary member.',

                'pm_dob_y.required_if' =>
                    'Primary member year of birth is required.',
                'pm_dob_m.required_if' =>
                    'Primary member month of birth is required.',
                'pm_dob_d.required_if' =>
                    'Primary member day of birth is required.',

                'contract_policy_plan_no.required' => 'Policy or plan number is required for extended health coverage.',
                'authorize_us_to_direct_bill.required' => 'Please indicate if the clinic can directly bill your insurance',
                'member_certificate_no.required' => 'Member certificate number is required for extended health coverage.',

                // Second insurance
                'second_insurance_coverage.required' => 'Please choose Second insurance coverage option.',

                'second_insu_comp_name.required_if' => 'Insurance company name is required for secondary coverage.',

                'primary_member_name_2.required_if' => 'Primary member name is required for secondary insurance.',

                'contract_policy_plan_no_2.required_if' => 'Policy or plan number is required for secondary insurance.',

                'member_certificate_no_2.required_if' => 'Member certificate number is required for secondary insurance.'
            ]);

            try {
                DB::beginTransaction();
                $data = MedicalForm::where('customer_id', $request->customer_id)->first();

                // Update Insurance Detail of the client.
                $data->benefits_insurance_company_name = $request->health_benefit_company;
                $data->primary_member = $request->is_primary_member;
                $data->primary_member_name = $request->primary_member;
                if(!empty($request->pm_dob_y) && !empty($request->pm_dob_m) && !empty($request->pm_dob_d)) {
                    $data->primary_member_dob  = get_formatted_date($request->pm_dob_y.'-'.$request->pm_dob_m.'-'.$request->pm_dob_d, 'Y-m-d');
                }
                $data->contract_policy_plan_no = $request->contract_policy_plan_no;
                $data->member_certificate_no = $request->member_certificate_no;
                $data->authorize_us_to_direct_bill = $request->authorize_us_to_direct_bill ?? 'No';
                $data->second_insurance_coverage = $request->second_insurance_coverage ?? 'No';
                $data->second_insu_comp_name = $request->second_insu_comp_name;
                $data->primary_member_name_2 = $request->primary_member_name_2;
                if(!empty($request->pm2_dob_y) && !empty($request->pm2_dob_m) && !empty($request->pm2_dob_d)) {
                    $data->primary_member_dob_2  = get_formatted_date($request->pm2_dob_y.'-'.$request->pm2_dob_m.'-'.$request->pm2_dob_d, 'Y-m-d');
                }

                $data->contract_policy_plan_no_2 = $request->contract_policy_plan_no_2;
                $data->member_certificate_no_2 = $request->member_certificate_no_2;
                // End Here
                $data->save();
                DB::commit();
                $customer_id = Crypt::encryptString($request->customer_id);
                return redirect()->route('medical_form', $customer_id)->with('success', 'Infomation Validated. Please click here to continue to Health History');
            }
            catch(Exception $e) {
                DB::rollBack();
                $customer_id = Crypt::encryptString($request->customer_id);
                return redirect()->route('medical_form', $customer_id)->withErrors('error', dd('Validation failed!', $e->getMessage()));
            }
        }

        if($request->submit_form == 'three') {
            // pr($request->all()); die;
            $request->validate(
                [
                    'v_accident_or_injured' => 'nullable|in:Yes,No',
                    'all_pertinent_infomation' => 'required_if:v_accident_or_injured,Yes',
                    'primary_complaint' => 'required',
                    'refer_by_practitioner' => 'required',
                    'health_cre_profess_name' => 'required',
                    'family_doc_addrs' => 'required',
                    'received_massage_before' => 'required',
                    'received_treatment_from_another' => 'required|in:Yes,No',
                    'if_yes_treatment_type' => 'required_if:received_treatment_from_another,Yes',
                    'current_medications' => 'max:50',
                    'any_allergies' => 'required|in:Yes,No',
                    'allergy_lst' => 'required_if:any_allergies,Yes',
                    'list_all_surgeries' => 'nullable|string|max:150',
                    'internal_pin_wire_joint' => 'required|in:Yes,No',
                    'joint_or_pin_text' => 'required_if:internal_pin_wire_joint,Yes',
                ],
                [
                    // Medical info
                    'all_pertinent_infomation.required_if' =>
                        'Please provide details related to the accident or injury.',

                    'primary_complaint.required' => 'Please describe your primary complaint.',

                    'received_treatment_from_another.required' => 'Please specify whether you received treatment elsewhere.',

                    'if_yes_treatment_type.required_if' => 'Please specify the treatment received.',

                    'any_allergies.required' => 'Please indicate whether you have any allergies.',

                    'allergy_lst.required_if' => 'Please list your allergies.',

                    'internal_pin_wire_joint.required' => 'Please specify if you have any internal pins, wires, or joint replacements.',

                    'joint_or_pin_text.required_if' => 'Please provide details about the pin, wire, or joint.'
                ]
            );

            // Third Part of the medical form Save 
            try {
                DB::beginTransaction();
                $data = MedicalForm::where('customer_id', $request->customer_id)->first();

                $data->v_accident_or_injured = $request->v_accident_or_injured ?? 'No';
                $data->all_pertinent_infomation = $request->all_pertinent_infomation;
                $data->other_current_injuries = $request->other_current_injuries;
                $data->primary_complaint = $request->primary_complaint;
                $data->refer_by_practitioner = $request->refer_by_practitioner;
                $data->health_cre_profess_name = $request->health_cre_profess_name;
                $data->family_doc_addrs = $request->family_doc_addrs;
                $data->received_massage_before = $request->received_massage_before;
                $data->received_treatment_from_another = $request->received_treatment_from_another;
                $data->if_yes_treatment_type = $request->if_yes_treatment_type;
                $data->current_medications = $request->current_medications;
                $data->any_allergies = $request->any_allergies;
                $data->allergy_lst = $request->allergy_lst;
                $data->list_all_surgeries = $request->list_all_surgeries;
                $data->cardiovascular = (!empty($request->cardiovascular))?implode(',', $request->cardiovascular):'';

                $data->gastrointestinal = (!empty($request->gastrointestinal))?
                implode(',', $request->gastrointestinal):'';
                $data->muscle_joint = (!empty($request->muscle_joint))?
                implode(',', $request->muscle_joint):'';
                $data->respiratory = (!empty($request->respiratory))?
                implode(',', $request->respiratory):'';
                $data->skin = (!empty($request->skin))?
                implode(',', $request->skin):'';
                $data->head_neck = (!empty($request->head_neck))?
                implode(',', $request->head_neck):'';

                $otherConditions = $request->other_conditions ?? [];
                if (in_array('Diabetes', $otherConditions)) {

                    // Remove plain "Diabetes" first
                    $otherConditions = array_values(
                        array_filter($otherConditions, fn ($v) => $v !== 'Diabetes')
                    );

                    if (!empty($request->diabetes_type)) {
                        // Append with type
                        $otherConditions[] = 'Diabetes - ' . trim($request->diabetes_type);
                    } else {
                        // Append only Diabetes
                        $otherConditions[] = 'Diabetes';
                    }
                }
                if(in_array('Cancer', $otherConditions)) {
                    // Remove Plain "Cancer" First
                    $otherConditions = array_values(
                        array_filter($otherConditions, fn($v) => $v !== 'Cancer')
                    );
                    if(!empty($request->cancer_type)) {
                        $otherConditions[] = 'Cancer - '. trim($request->cancer_type);
                    }
                    else {
                        $otherConditions[] = 'Cancer';
                    }
                }
                $data->other_medical_conditions = implode(',', $otherConditions);

                $data->is_family_history = $request->is_family_history ?? 'No';
                $data->internal_pin_wire_joint = $request->internal_pin_wire_joint;
                $data->joint_or_pin_text = $request->joint_or_pin_text;
                $data->good_health = $request->good_health;
                $data->pregnant = $request->pregnant ?? 'No';
                $data->pregnant_due_date = ($request->pregnant_due_date) ?get_formatted_date($request->pregnant_due_date, 'Y-m-d') : NULL;
                $data->pregnancy_three_month = $request->pregnant_in_three_month ?? 'No';

                $data->save();
                DB::commit();
                $customer_id = Crypt::encryptString($request->customer_id);
                return redirect()->route('medical_form', $customer_id)->with('success', 'Infomation Validated. Please click here to continue Acknowledgments');
            }
            catch(Exception $e) {
                DB::rollBack();
                $customer_id = Crypt::encryptString($request->customer_id);
                return redirect()->route('medical_form', $customer_id)->withErrors('error', dd('Validation failed!', $e->getMessage()));
            }
        }

        if($request->submit_form == 'four') {
            // pr($request->all()); die;
            $request->validate(
                [
                    'acknowlege' => 'required',
                    'acknowlegeName' => 'required|max:40',
                    'acknowlege_2' => 'required'
                ],
                [
                    // Acknowledgement
                    'acknowlege.required' => 'You must acknowledge before submitting the form.',
                    'acknowlegeName.required' => 'Please enter your name for acknowledgment.',
                    'acknowlegeName.max' => 'Acknowledgment name may not exceed 40 characters.',
                    'acknowlege_2.required' => 'You must agree to the second acknowledgment.'
                ]
            );
            try {
                DB::beginTransaction();
                $data = MedicalForm::where('customer_id', $request->customer_id)->first();

                $data->acknowlege = $request->acknowlege;
                $data->acknowlege_name = $request->acknowlegeName;
                $data->choose_date = get_formatted_date($request->choose_date, 'Y-m-d');
                $data->acknowledge_text = $request->hdnAcknowlege;
                $signature = $request->signature;

                // Remove base64 prefix
                $image = str_replace('data:image/png;base64,', '', $signature);
                $image = str_replace(' ', '+', $image);

                $signature_imageName = 'signatures/' . uniqid() . '.png';

                Storage::disk('public')->put($signature_imageName, base64_decode($image));
                $data->signature_path = $signature_imageName;
                $data->save();

                DB::commit();

                // Generate PDF and send mail to Admin
                $fnm = $data->first_name;
                $mnm = $data->middle_name ?? '';
                $lnm = $data->last_name ?? '';
                $fullnm = $fnm.' '.$mnm.' '.$lnm; // Full Name
                // die('sdfds');
                $pdf = Pdf::loadView('pdf.medical-form-pdf', ['data' => $data]);    //Load data into pdf blade template

                $file_name = 'patient_intake_health_form_'.strtolower($fnm).' '.strtolower($mnm).' '.strtolower($lnm).'_'.$data->id.'.pdf'; // create PDF file name

                $filePath = 'medical_forms/' . $file_name;
                Storage::disk('public')->put($filePath, $pdf->output());    // Store the file in medical_forms directory under public directory.
                
                // update pdf file path in DB
                MedicalForm::where('id', $data->id)->update(['pdf_file_path' => $filePath]);
                $setting = getSetting();
                if($setting->global_mail == 1) {
                    $to = 'mca.asheesh@gmail.com';
                    // $to = 'info@divinetouchtherapy.com';
                    Mail::to($to)->send(new MedicalFormPdfMail($fullnm, $file_name, storage_path('app/public/' . $filePath)));
                }
                // End Here
                // $customer_id = Crypt::encryptString($request->customer_id);
                return redirect()->route('home')->with('success', 'All Data Saved Successfully.');
            }
            catch(Exception $e) {
                DB::rollBack();
                $customer_id = Crypt::encryptString($request->customer_id);
                return redirect()->route('medical_form', $customer_id)->withErrors('error', dd('Validation failed!', $e->getMessage()));
            }
        }
    }

    private function sendOtpMail($client)
    {
        $email = $client->email;
        $otp = generateOtp();
        if(empty($client->email)) {
            $data = User::where('family_id', $client->family_id)->whereNotNull('family_id')->whereNotNull('email')->first();
            $email = $data->email;
        }
        
        session([
            'fom_otp' => $otp,
            'fom_otp_expires_at' => now()->addMinutes(5),
            'fom_otp_verified' => false,
            'fom_otp_email' => $email,
        ]);
        if(!session()->has('otp_mail_sent')) {
            Mail::raw(
                "Your OTP for medical form verification is {$otp}. It is valid for 5 minutes.",
                function ($mail) use ($email) {
                    $mail->to($email)
                        ->bcc('mca.asheesh@gmail.com')
                        ->subject('Medical form Email Verification OTP');
                }
            );
            session(['otp_mail_sent' => 'yes']);
        }
        
    }

    public function validateFormOTP(Request $request)
    {
        // echo $request->otp_email;die;
        if (!session()->has('fom_otp')) {
            return response()->json([
                'status' => false,
                'message' => 'OTP expired. Please resend.'
            ]);
        }

        if (now()->greaterThan(session('fom_otp_expires_at'))) {
            session()->forget(['fom_otp', 'fom_otp_expires_at']);
            return response()->json([
                'status' => false,
                'message' => 'OTP expired'
            ]);
        }

        if($request->otp == session('fom_otp')) {
            session()->forget(['fom_otp','fom_otp_expires_at','fom_otp_email']);
            session(['fom_otp_verified' => true]);
            return response()->json([
                'status' => true,
                'massage' => 'OTP verified Successfully.'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid OTP'
        ]);

    }

    /*public function store(Request $request)
    {
        try {
            $data = MedicalForm::where('id', 24)->first();

            $pdf = Pdf::loadView('pdf.medical-form-pdf', ['data' => $data]);    //Load data into pdf blade template
            return $pdf->download('medical-form.pdf');

            $booking_id = Crypt::encryptString($request['booking_id']);
            return redirect()->route('medical_form', $booking_id)->with('success', 'Medical Form Submitted Successfully.');
        }
        catch(Exception $e) {
            $booking_id = Crypt::encryptString($request['booking_id']);
            return redirect()->route('medical_form', $booking_id)->withErrors('error', dd('Validation failed!', $e->getMessage()));
        }
    }*/

    private function updateUserDetailByMedicalFormData($customer_id, $input_email, $input_mobile, $doby,$dobm,$dobd,$gender,$address,$city,$province,$postal_code)
    {
        // update in users table if users table have no entry
        $user = User::findOrFail($customer_id);

        if(!empty($user->email) && $user->email != $input_email) {
            // check input email with family id in user table
            $chkfamilyemail = User::where('family_id', $user->family_id)->where('email', $input_email)->first();
            if(empty($chkfamilyemail)) { // if email not match in family then check email unique in table
                $checkemail = User::where('email', $input_email)->first();
                if(empty($checkemail)) { // consider new email id for enter
                    // die('test if 2');
                    $user->email = $input_email;
                }
            }
        }
        else {
            // Check email exist in family
            $checkfamilyemail = User::where('family_id', $user->family_id)->where('email', $input_email)->first();
            if(empty($checkfamilyemail)) {
                // if email not exist in family then check in table for unique.
                $checkemail = User::where('email', $input_email)->first();
                if(empty($checkemail)) {
                    // die('test else');
                    $user->email = $input_email;
                }
            }
            else {
                // In Family, email id exist. so no need to add for this dependent.
            }
        }

        if(!empty($user->mobile) && $user->mobile != $input_mobile) {
            // check input email with family id in user table
            $chkfamilymobile = User::where('family_id', $user->family_id)->where('mobile', $input_mobile)->first();
            if(empty($chkfamilymobile)) { // if email not match in family then check email unique in table
                $checkmobile = User::where('mobile', $input_mobile)->first();
                if(empty($checkmobile)) { // consider new email id for enter
                    $user->mobile = $input_mobile;
                }
            }
        }
        else {
            // if customer have no mobile then check entered email, if empty then store it.
            $checkfamilymobile = User::where('family_id', $user->family_id)->where('mobile', $input_mobile)->first();
            if(empty($checkfamilymobile)) {
                $checkmobile = User::where('mobile', $input_mobile)->first();
                if(empty($checkmobile)) {
                    $user->mobile = $input_mobile;
                }
            }
        }

        if(empty($user->dob) || $user->dob == '1970-01-01') {
            if(!empty($doby) && !empty($dobm) && !empty($dobd)) {
                $user->dob  = get_formatted_date($doby.'-'.$dobm.'-'.$dobd, 'Y-m-d');
            }
        }
        if(empty($user->gender) && !empty($gender)) {
            $user->gender = $gender;
        }
        if(empty($user->address) && !empty($address)) {
            $user->address = $address;
        }
        if(empty($user->city) && !empty($city)) {
            $user->city = $city;
        }
        if(empty($user->state) && !empty($province)) {
            $user->state = $province;
        }
        if(empty($user->postal_code) && !empty($postal_code)) {
            $user->postal_code = $postal_code;
        }
        $user->save();

    }

}
