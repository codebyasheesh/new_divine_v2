<?php

namespace App\Http\Controllers;

use App\Mail\SendContactUsMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact.index');
    }

    public function sendcontactmail(Request $request)
    {
        $request->validate([
            'first_name'  => 'required|string',
            'last_name'  => 'required|string',
            'email'   => 'required|email',
            'mobile'  => 'required|regex:/^[0-9]{3}[-\s]?[0-9]{3}[-\s]?[0-9]{4}$/', // 10 digits with optional space/dash
            'message' => 'required'
        ]);
        $firstName = trim($request->first_name);
        $lastName  = trim($request->last_name);
        $email     = trim($request->email);
        $mobile    = trim($request->mobile);
        $message    = trim($request->message);
        $token = $request->token;

        if(!empty($token)) {
            $secretKey = '6LenkgwrAAAAADFjBfq0gFVqZ3pGa8o8OyfxpKgI';
            // Google reCAPTCHA verification API Request  
            $api_url = 'https://www.google.com/recaptcha/api/siteverify';  
            $resq_data = array(  
                'secret' => $secretKey,
                'response' => $token,
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
            if($responseData->success) {
                // Mail Send
                $to = 'info@divinetouchtherapy.com';
                $data = [
                    'name' => $firstName.' '.$lastName,
                    'email' => $email,
                    'mobile' => $mobile,
                    'message' => $message
                ];
                Mail::to($to)->bcc('mca.asheesh@gmail.com')->send(new SendContactUsMail($data));
                return response()->json(['status' => true, 'message' => 'Mail sent Successfully.'], 200);
            }
        }
    }

    public function sendOtpEmail(Request $request)
    {
        $email = $request->email;

        // Generate OTP
        $otp = generateOtp();

        session([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
            'otp_email' => $email
        ]);

        Mail::raw(
            "Your OTP is {$otp}. It is valid for 5 minutes.",
            function ($mail) use ($email) {
                $mail->to($email)
                    ->subject('Email Verification OTP');
            }
        );

        return response()->json([
            'status' => true,
            'message' => 'OTP sent to your email'
        ]);
    }

    public function checkcontactemailotp(Request $request)
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

            // New Email entered
            return response()->json([
                'status' => true,
                'message' => 'OTP verified successfully'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid OTP'
        ]);
    }
}
