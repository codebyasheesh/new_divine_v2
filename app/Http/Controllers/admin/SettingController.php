<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\WeeklySchedule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SettingController extends Controller
{
    public function index()
    {
        $id = 1;
        $data = Setting::findOrFail($id);
        // pr($data->toArray()); die;
        return view('admin.setting.index', compact('data'));
    }

    public function updateSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tax_name'          => 'nullable|string|max:10',
            'tax_value'         => 'nullable|numeric',
            'notes'             => 'nullable|string',
            'terms'             => 'nullable|string',
            'global_mail'       => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $setting = Setting::findOrFail($request->id);

            $setting->hst_registration_no       = $request->hst_registration_no;
            $setting->global_mail               = $request->global_mail;
            $setting->duration                  = $request->duration;
            $setting->start_time                = date('H:i:s', strtotime($request->start_time));
            $setting->end_time                  = date('H:i:s', strtotime($request->end_time));
            $setting->tax_name                  = $request->tax_name;
            $setting->tax_value                 = $request->tax_value;
            $setting->notes                     = $request->notes;
            $setting->terms                     = $request->terms;
            $setting->square_application_id     = $request->application_id;
            $setting->square_access_token       = $request->access_token;
            $setting->square_location_id        = $request->square_location_id;
            $setting->square_environment        = $request->square_environment;
            $setting->twilio_sid                = $request->twilio_sid;
            $setting->twilio_auth_token         = $request->twilio_auth_token;
            $setting->twilio_from               = $request->twilio_from;
            $setting->google_captcha_sitekey    = $request->site_key;
            $setting->google_captcha_secretkey  = $request->secret_key;

            $setting->save();
            return redirect()->back()->with('success', 'Settings updated successfully.');
        }
        catch(Exception $e) {
            return redirect()->back()->with('error', 'Settings could not be updated. '.$e->getMessage());
        }
    }

    public function companyDetail()
    {
        $id = 1;
        $data = Setting::findOrFail($id);
        return view('admin.setting.company_detail', compact('data'));
    }

    public function updateCompanyDetail(Request $request)
    {
        $request->merge([
            'company_phone' => str_replace([' ','-'], '', $request->company_phone),
        ]);
        $validator = Validator::make($request->all(), [
            'company_name'              => 'required|max:150',
            'company_phone'             => 'required|max:10',
            'company_email'             => 'required|string|email|max:60',
            'whatsapp_no'               => 'required',
            'company_address'           => 'required',
            'company_tax_reg_number'    => 'required',
            'backend_logo'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'frontend_logo'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try{
            $setting = Setting::findOrFail($request->id);

            $invalidStartSchedule = WeeklySchedule::whereTime('start_time', '<', date('H:i:s', strtotime($request->start_time)))
                                ->first();
            $dayname = ['1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday'];
            if ($invalidStartSchedule) {
                return redirect()->back()
                    ->withInput()
                    ->with('error',
                        "In Weekly Schedule, ".ucfirst($dayname[$invalidStartSchedule->day_of_week]).
                        " schedule start time ".date('h:i A', strtotime($invalidStartSchedule->start_time))." exist, which ".
                        "cannot be earlier than clinic opening time ".date('h:i A', strtotime($request->start_time))."."
                    );
            }

            $invalidEndSchedule = WeeklySchedule::whereTime('end_time', '>', date('H:i:s', strtotime($request->end_time)))
                            ->first();

            if ($invalidEndSchedule) {

                return redirect()->back()
                    ->withInput()
                    ->with('error',
                        "In weekly Schedule ".ucfirst($dayname[$invalidEndSchedule->day_of_week]).
                        " schedule end time ".date('h:i A', strtotime($invalidEndSchedule->end_time))." which".
                        "cannot be later than clinic closing time ".date('h:i A', strtotime($request->end_time))."."
                    );
            }

            $setting->company_name              = $request->company_name;
            $setting->company_phone             = $request->company_phone;
            if(!empty($request->whatsapp_no)) {
                $setting->company_whatsapp      = $request->whatsapp_no;
            }
            $setting->company_email             = $request->company_email;
            $setting->company_address           = $request->company_address;
            $setting->company_tax_reg_number    = $request->company_tax_reg_number;
            $setting->duration                  = $request->duration;
            $setting->start_time                = date('H:i:s', strtotime($request->start_time));
            $setting->end_time                  = date('H:i:s', strtotime($request->end_time));
            $setting->tax_name                  = $request->tax_name;
            $setting->tax_value                 = $request->tax_value;
            $setting->notes                     = $request->notes;
            $setting->terms                     = $request->terms;

            if ($request->hasFile('backend_logo')) {
                $backendLogo = $request->file('backend_logo');
                $backendLogoName = time() . '_backend-logo.' . $backendLogo->getClientOriginalExtension();
                $backendLogo->move(public_path('admin_assets/assets/img'), $backendLogoName);
                $setting->backend_logo = $backendLogoName;
            }

            if ($request->hasFile('frontend_logo')) {
                $frontendLogo = $request->file('frontend_logo');
                $frontendLogoName = time() . '_frontend-logo.' . $frontendLogo->getClientOriginalExtension();
                $frontendLogo->move(public_path('admin_assets/assets/img'), $frontendLogoName);
                $setting->frontend_logo = $frontendLogoName;
            }
            $setting->save();
            return redirect()->back()->with('success', 'Company Detail updated successfully.');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Company Detail could not be updated. '.$e->getMessage());
        }
    }

    public function systemSettings()
    {
        $id = 1;
        $data = Setting::findOrFail($id);
        return view('admin.setting.system_setting', compact('data'));
    }

    public function updateSystemSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'global_sms'     => 'required',
            'online_payment' => 'required',
            'googlecaptcha'  => 'required',
            'global_mail'    => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $setting = Setting::findOrFail($request->id);
            $setting->global_mail  = $request->global_mail;
            $setting->global_sms = $request->global_sms;
            $setting->online_payment = $request->online_payment;
            $setting->googlecaptcha = $request->googlecaptcha;
            $setting->save();
            return redirect()->back()->with('success', 'System setting updated successfully.');
        }
        catch(Exception $e) {
            return redirect()->back()->with('error', 'Company Detail could not be updated. '.$e->getMessage());
        }
    }

    public function apiSetting()
    {
        $id = 1;
        $data = Setting::findOrFail($id);
        return view('admin.setting.api_setting', compact('data'));
    }

    public function updateApi(Request $request)
    {
        try{
            $setting = Setting::findOrFail($request->id);
            $setting->square_application_id     = $request->application_id;
            $setting->square_access_token       = $request->access_token;
            $setting->square_location_id        = $request->square_location_id;
            $setting->square_environment        = $request->square_environment;
            $setting->twilio_sid                = $request->twilio_sid;
            $setting->twilio_auth_token         = $request->twilio_auth_token;
            $setting->twilio_from               = $request->twilio_from;
            $setting->google_captcha_sitekey    = $request->site_key;
            $setting->google_captcha_secretkey  = $request->secret_key;

            $setting->save();
            return redirect()->back()->with('success', 'Settings updated successfully.');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Settings could not be updated. '.$e->getMessage());
        }
    }

    public function smtpSetting()
    {
        $id = 1;
        $data = Setting::findOrFail($id);
        return view('admin.setting.smtp_setting', compact('data'));
    }

    public function updatesmtp(Request $request)
    {
        try{
            $setting = Setting::findOrFail($request->id);
            $setting->mail_host         = $request->mail_host;
            $setting->mail_port         = $request->mail_port;
            $setting->mail_encryption   = $request->mail_encryption;
            $setting->mail_username     = $request->mail_username;
            $setting->mail_password     = $request->mail_password;
            $setting->mail_from_address = $request->mail_from_address;
            $setting->mail_from_name    = $request->mail_from_name;

            $setting->save();
            return redirect()->back()->with('success', 'SMTP Setting saved successfully.');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Settings could not be updated. '.$e->getMessage());
        }
    }
}
