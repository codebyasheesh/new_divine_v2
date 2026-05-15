<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    // This method will show the login Screen
    public function index() {
        return view('admin.login');
    }
    
    // 
    public function authenticate(Request $request) {
        if($request->filled('otp')) {
            $validator = Validator::make($request->all(), [
                'otp' => 'required|digits:6'
            ]);

            if($validator->fails()) {
                return redirect()->route('admin.login')->withErrors($validator);
            }
            $admin = User::find(session('otp_admin_id'));
            if (!$admin) {
                return redirect()->route('admin.login')
                    ->with('error', 'Session expired. Please login again.');
            }

            // Check OTP expiry (5 minutes)
            if (time() > strtotime($admin->otp_expires_at)) {
                session()->forget(['otp_admin_id', 'otp_required', 'otp_expiry_time']);
                return redirect()->route('admin.login')
                    ->with('error', 'OTP expired');
            }

            // Validate OTP
            if ($admin->otp_code !== $request->otp) {
                return redirect()->route('admin.login')
                    ->with('error', 'Invalid OTP');
            }

            // OTP success → cleanup
            User::where('email', $admin->email)->update([
                'otp_code'       => null,
                'otp_expires_at' => null
            ]);

            Auth::guard('admin')->login($admin);
            session()->forget(['otp_admin_id', 'otp_required', 'otp_expiry_time']);

            return redirect()->route('admin.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 1: EMAIL + PASSWORD VERIFICATION
        |--------------------------------------------------------------------------
        */
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.login')
                ->withInput()
                ->withErrors($validator);
        }

        // Verify credentials ONLY (no login yet)
        if (!Auth::guard('admin')->validate([
            'email'    => $request->email,
            'password' => $request->password
        ])) {
            return redirect()->route('admin.login')
                ->with('error', 'Either email or password is invalid');
        }

        $admin = User::where('email', $request->email)->first();

        // Role check
        if ($admin->role !== 'admin') {
            return redirect()->route('admin.login')
                ->with('error', 'You are not authorized to access this page.');
        }

        // Generate OTP
        $otp = generateOtp();
        $expiryTimestamp = time() + 300; // 5 minutes
        User::where('email', $request->email)->update([
            'otp_code' => $otp,
            'otp_expires_at' => date('Y-m-d H:i:s', $expiryTimestamp) // 8 Minutes.
        ]);
        $otpText = "Your OTP is {$otp}. It is valid for 5 minutes.";
        
        try {
            $objTwilio = new TwilioService();
            $objTwilio->sendSms($admin->mobile, $otpText);
            $objTwilio->sendSms($admin->alternate_mobile, $otpText);
        }
        catch(\Throwable $e) {
            // Catch EVERYTHING (Exception + Error)
            Log::error('SMS sending error: ' . $e->getMessage());
        }

        try {
            Mail::raw($otpText, function ($mail) use ($admin) {
                $mail->to($admin->email)
                     ->subject('OTP Verification');
            });

        } catch (\Throwable $e) {
            // Catch EVERYTHING (Exception + Error)
            Log::error('Mail sending error: ' . $e->getMessage());
        }

        session([
            'otp_required' => true,
            'otp_admin_id' => $admin->id,
            'otp_expiry_time' => $expiryTimestamp
        ]);

        return redirect()->route('admin.login')
            ->with('success', 'OTP sent to your email address');
    }
    
    public function logout() {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function unsetOTPSessions()
    {
        session()->forget(['otp_admin_id', 'otp_required', 'otp_expiry_time']);
        return redirect()->route('admin.login');
    }
}
