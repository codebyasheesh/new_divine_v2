<?php

namespace App\Http\Controllers;

use App\Mail\UserRegistration;
use App\Models\customer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    // Open the Registration Page
    public function register()
    {
        return view('frontend.register');
    }

    // Process Registration
    public function processRegister(Request $request)
    {
        // Validate the request data
        // echo '<pre>'; print_r($request->all()); die;
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:60',
            'last_name' => 'required|string|max:60',
            'email' => 'required|email|max:80|unique:users,email,NULL,id,family_id,NULL',
            'mobile' => 'required|max:10|unique:users,mobile,NULL,id,family_id,NULL',
            'password' => 'required|min:8|confirmed',
        ]);
        try {
            DB::beginTransaction();
            if($validator->passes()) {
            // Create a new user
                $user = new User();
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->mobile = $request->mobile;
                $user->password = Hash::make($request->password);
                $user->email_verify_token = uniqid();
                $user->family_id = 0;
                $user->role = 'customer'; // Set the default role to 'customer'
                $create_user = $user->save();

                /*if($create_user) {
                    // create a customer record in the customer table
                    $customer = new customer();
                    $customer->user_id = $user->id; // Assuming you have a user_id column in the customer table
                    $customer->name = $request->name;
                    $customer->email = $request->email;
                    $customer->mobile = $request->mobile;
                    $customer->status = 1;
                    $customer->save();
                }*/
                // Sene Mail to user After Register Successfull
                $activation_link = route('verify_email', $user->email_verify_token);
                $setting = getSetting();
                if($setting->global_mail == 1) {
                    Mail::to($request->email)->bcc('mca.asheesh@gmail.com')->send(new UserRegistration($user, $activation_link));
                }
                // End Here

                DB::commit();
                // Optionally, you can log the user in after registration
                // auth()->login($user);

                return redirect()->route('home')->with('success', 'Registration successful. Please log in.');
            }
            else {
                // Redirect back with errors
                // die('sdfdsf');
                return redirect()->route('register')->withErrors($validator)->withInput();
            }
        }
        catch (Exception $e) {
            // die('An error occurred while processing your request. Please try again later. '.$e->getMessage());
            return redirect()->route('register')->with('error', 'An error occurred while processing your request. Please try again later. '.$e->getMessage());
            DB::rollback();
        }
    }

    public function login()
    {
        return view('frontend.login');
    }   

    public function processLogin(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:60',
            'pwd' => 'required|min:8',
        ]);
        try {
            if ($validator->passes()) {
                $verify_check = User::where('email', $request->email)->first(['email_verified_at', 'email_verify_token']);
                if(!empty($verify_check) && (($verify_check->email_verified_at != NULL) && ($verify_check->email_verify_token == NULL))) {
                    // Attempt to log the user in
                    if (Auth::attempt(['email' => $request->email, 'password' => $request->pwd])) {
                        // Authentication passed...
                        return redirect()->route('my_account')->with('success', 'Login successful.');
                    } else {
                        return redirect()->route('login')->with('error', 'Invalid credentials. Please try again.');
                    }
                }
                else {
                    return redirect()->route('login')->with('error', 'Your Account is not verfied. Please check your registered mail and click on verify link');
                }
            } 
            else {
                // Redirect back with errors
                return redirect()->route('login')->withErrors($validator)->withInput();
            }
        } 
        catch (Exception $e) {
            return redirect()->route('login')->with('error', 'An error occurred while processing your request. Please try again later. '.$e->getMessage());
        }
    }

    public function signOut() {
        // Log out the user
        Auth::logout();

        // Redirect to the home page with a success message
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }

    public function changePassword(Request $request) {
        // pr($request->all()); die;
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        // pr($user); die;

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 404,
                'message' => 'Current password is incorrect.'
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Password updated successfully.'
        ]);
    }

    public function verifyEmail($token)
    {
        try {
            $data = User::where('email_verify_token', $token)->first(['id', 'email_verified_at']);
            if(!empty($data))
            {
                User::where('id', $data->id)->update(['email_verify_token' => NULL, 'email_verified_at' => date('Y-m-d H:i:s')]);
            }
            return redirect()->route('login')->with('success', 'Your Account is verfied Now. You can login now.');
        }
        catch(Exception $e) {
            return redirect()->route('login')->withErrors('Your Account could not be verified please contact to system adminstration');
        }
        
    }
}