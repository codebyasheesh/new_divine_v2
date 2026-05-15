<?php

namespace App\Http\Controllers\admin;

use App\Mail\UserRegistrationByAdmin;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\MedicalForm;
use App\Models\Service;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Pest\ArchPresets\Custom;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Show the Index Page where Registered Customers are shown Here
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the Customers list using Ajax Request when page load
    */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select(['id','first_name', 'password', 'last_name', 'email', 'mobile', 'dob', 'is_primary', 'created_at'])
            ->where('role', 'customer');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row){
                    $profile_url = route('admin.userprofile', $row->id);

                    $first = $row->first_name ?? '';
                    $last = $row->last_name ?? '';
                    if(empty($last)) {
                        $full_name = trim($first);
                    }
                    else {
                        $full_name = trim("$last, $first");
                    }
                    return '<a class="link-underline-light" href="'.$profile_url.'">'.$full_name.'</a>';
                })
                // This works because $data is a Builder — DataTables will append ORDER BY to SQL
                ->orderColumn('name', function ($data, $order) {
                    $data->orderBy('last_name', $order)->orderBy('first_name', $order);
                })

                ->filter(function ($query) use ($request) {

                    // GLOBAL SEARCH (FROM DATATABLE SEARCH BOX)
                    if ($request->has('search') && $request->search['value'] !== '') {

                        $search = $request->search['value'];

                        $query->where(function ($q) use ($search) {
                            $q->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name',  'like', "%{$search}%")
                            ->orWhere('email',      'like', "%{$search}%")
                            ->orWhere('mobile',     'like', "%{$search}%");
                        });
                    }
                })
                ->addColumn('mobile', function($row) {
                    if(strlen($row->mobile) === 10) {
                        return substr($row->mobile, 0, 3).'-'.substr($row->mobile, 3, 3).'-'.substr($row->mobile, 6, 4);
                    }
                })
                ->addColumn('dob', function ($row){
                    if(!empty($row->dob)) {
                        return get_formatted_date($row->dob, 'M d, Y');
                    }
                    else {
                        return 'MDY';
                    }
                    
                })
                ->addColumn('action', function($row){
                    $delete_client = "deleteClient('".$row->id."')";
                    $edit_detail = "viewUserDetail('".$row->id."')";
                    $member_url = route('admin.members', $row->id);
                    $family_lnk = '';
                    // if($row->is_primary == 1) {
                        $family_lnk = '<a href="'.$member_url.'" class="btn btn-sm btn-primary me-1" data-bs-toggletip="tooltip" data-bs-title="Family Members"><i class="bi bi-people"></i> Family</a>';
                    // }
                    return '<a href="javascript:void(0);" onclick="'.$edit_detail.'" class="btn btn-sm btn-success me-1" data-bs-toggle="modal" data-bs-target="#editUserPop" data-bs-whatever="editUserPop"
                    role="button" data-bs-toggletip="tooltip" data-bs-title="Edit User"><i class="bi bi-pencil-square"></i> Edit</a>
                    '.$family_lnk.'
                    <a href="javascript:void(0);" onclick="'.$delete_client.'" class="btn btn-sm btn-danger" data-bs-toggletip="tooltip" data-bs-title="Delete Client"><i class="bi bi-trash"></i> Delete</a>';
                })
                ->rawColumns(['name', 'mobile', 'action'])
                ->make(true);
        }
    }

    /**
     * Displays the Registered user Detail on POPUP.
     *
     * This method retrieves user data based on the provided ID
     * and renders the user detail.
     *
     * @param int $id The unique identifier of the user.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse The profile view or a redirect if the user is not found.
     */
    public function view(Request $request)
    {
        $id = $request->get('id');
        $data = User::where('id', $id)->first(['id', 'family_id', 'first_name', 'last_name','email', 'mobile', 'city', 'state', 'address','gender', 'dependent', 'is_primary', 'postal_code', 'dob', 'remark']);
        
        // $data->dob = get_formatted_date($data->dob, 'M d, Y');
        
        return response()->json([
            'code'=>'200',
            'data' => $data
        ]);
    }

    /**
     * Create a new user registration From the POPUP.
     *
     * This method collect user data with unique email id validation and save
     * the data in users and customers table also.
     *
     * @param $request post data of user.
     * @return response, of success or fail and redirect to the listing page.
     */
    public function add(Request $request)
    {
        $familyId = 0;

        $rules = [
            'first_name' => [
                'required',
                'min:2',
                'regex:/^[A-Za-z]+( [A-Za-z]+)*$/',
            ],
            'last_name' => [
                'required',
                'min:2',
                'regex:/^[A-Za-z]+$/', // only one word, alphabets only
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email,NULL,id,deleted_at,NULL', // unique globally
            ],
            'mobile' => [
                'required',
                'regex:/^[0-9]{3}[-\s]?[0-9]{3}[-\s]?[0-9]{4}$/', // 10 digits with optional space/dash
                'unique:users,mobile,NULL,id,deleted_at,NULL', // unique globally
            ],
            'gender' => [
                'required'
            ],
            'postal_code' => [
                'nullable',
                'regex:/^[A-Za-z0-9]{3}\s?[A-Za-z0-9]{3}$/',
            ]
        ];
        // pr($request->toArray()); die;
        $request->merge([
            'mobile' => str_replace([' ','-'], '', $request['mobile']),
            'postal_code' => str_replace(' ', '', $request['postal_code'])
        ]);
        $request->validate($rules);
        $setting = getSetting();
        try {
            DB::beginTransaction();
            $user = new User();
            $user->first_name = ucwords($request['first_name']);
            $user->last_name = ucwords($request['last_name']);
            $user->family_id = $familyId;
            $user->is_primary = $request['is_primary'];
            $user->email = $request['email'];
            $user->mobile = $request['mobile'];
            $user->email_verify_token = uniqid();
            $user->password = Hash::make($request['mobile']); // mobile will be used for password

            if(!empty($request['bday']) && !empty($request['bmonth']) && $request['byear']) {
                $user->dob = get_formatted_date($request['bday'].'-'.$request['bmonth'].'-'.$request['byear'], 'Y-m-d');
            }
            
            $user->address = $request['address'];
            $user->gender = $request['gender'];
            $user->city = ucwords($request['city']);
            $user->state = ucwords($request['state']);
            $user->postal_code = $request['postal_code'];
            $user->remark = $request['remark'];
            $create_user = $user->save();
            if($create_user) {
                $customer_dtl = array(
                    'customer_id' => $user->id,
                    'customer_name' => $user->name,
                    'customer_mobile' => $user->mobile,
                    'customer_email' => $user->email
                );

                $activatin_link = route('verify_email', $user->email_verify_token);
                if($setting->global_mail == 1) {
                    // Mail::to($request['email'])->bcc('mca.asheesh@gmail.com')->send(new UserRegistrationByAdmin($user, $activatin_link));
                }
            }
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Client added successfully! Password is mailed to client.'], 201);
        } catch (Exception $e) {
            //throw $th;
            DB::rollback();
            return response()->json(['status'=> false, 'error' => 'Client Could not be added due to some issue '. $e->getMessage()], 400);
        }
    }

    /**
     * Save the updated data of user
    */
    public function edit(Request $request)
    {
        $id = $request['id'];
        // $familyId = $request['e_family_id'];
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $email = $request['email'];
        $mobile = $request['mobile'];
        // $dob = $request['dob'];
        $dt = $request['bday'];
        $mn = $request['bmonth'];
        $yr = $request['byear'];
        $address = $request['address'];
        $gender = $request['gender'];
        $city = $request['city'];
        $state = $request['state'];
        $postal_code = $request['postal_code'];
        $address = $request['address'];
        $remark = $request['remark'];

        // Case 1: If editing a standalone user (family_id = 0)
        $rules = [
            'first_name' => [
                'required',
                'min:2',
                'regex:/^[A-Za-z]+( [A-Za-z]+)*$/',
            ],
            'last_name' => [
                'required',
                'min:2',
                'regex:/^[A-Za-z]+$/', // only one word, alphabets only
            ],
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($id)->whereNull('deleted_at'), // unique globally except current user
            ],
            'mobile' => [
                'nullable',
                'regex:/^[0-9]{3}[-\s]?[0-9]{3}[-\s]?[0-9]{4}$/',
                Rule::unique('users', 'mobile')->ignore($id)->whereNull('deleted_at'),
            ],
            'gender' => [
                'required'
            ],
            'postal_code' => [
                'nullable',
                'regex:/^[A-Za-z0-9]{3}\s?[A-Za-z0-9]{3}$/',
            ]
        ];

        // 🔥 CONDITIONAL VALIDATION BASED ON DEPENDENT VALUE
        if ($request->dependent === 'no') {
            $rules['email'][] = 'required';
            $rules['mobile'][] = 'required';
        }
        // die('test '.$request->dependent);
        $request->validate($rules);
        $request->merge([
            'mobile' => str_replace([' ','-'], '', $request['mobile']),
            'postal_code' => str_replace(' ', '', $request['postal_code'])
        ]);

        DB::beginTransaction();
        try{
            // Find user
            $user = User::findOrFail($id);
            // Update user data
            $user->first_name = ucwords($first_name);
            $user->last_name = ucwords($last_name);
            $user->email = $email;
            $user->mobile = $request['mobile'];
            if(!empty($dt) && !empty($mn) && !empty($yr)) {
                $user->dob = get_formatted_date($dt.'-'.$mn.'-'.$yr, 'Y-m-d');
            }

            // get the DOB from medical form table. if not available then update Medical Form Table.
            $medical_detail = MedicalForm::where('customer_id', $id)->first();
            if ($medical_detail) {
                // 2. Compare the dates (standardizing format helps avoid strtotime mismatches)
                if ($medical_detail->dob !== $user->dob) {
                    $medical_detail->dob = $user->dob;
                    $medical_detail->save(); // 3. Only hits the DB if necessary
                }
            }
            
            $user->city = ucwords($city);
            $user->gender = $gender;
            $user->state = ucwords($state);
            $user->postal_code = $request['postal_code'];
            $user->address = $address;
            $user->remark = $remark;
            $user->save();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Client Profile updated successfully.',
            ], 202);
        }
        catch(\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Update failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function profile(Request $request, $id) {
        $logged_user = User::withTrashed()->where('id', $id)->first(['id as customer_id', 'family_id', 'first_name', 'last_name', 'email', 'mobile', 'dob', 'address', 'city', 'state', 'gender','dependent', 'postal_code', 'remark', 'soap_note_link', 'created_at','deleted_at']);
        // pr($logged_user->toArray()); die;
        // Get Mediacal Form Detail of Customer or Family Member

        $logged_user_medical = MedicalForm::where('customer_id', $logged_user->customer_id)->first();
        // End Here

        $all_members = array(
            array(
                'id' => $logged_user->customer_id,
                'family_id' => $logged_user->family_id,
                'first_name' => $logged_user->first_name,
                'last_name' => $logged_user->last_name,
                'email' => $logged_user->email,
                'mobile' => $logged_user->mobile,
                'dob' => $logged_user->dob,
                'address' => $logged_user->address,
                'gender' => $logged_user->gender,
                'dependent' => $logged_user->dependent,
                'city' => $logged_user->city,
                'state' => $logged_user->state,
                'postal_code' => $logged_user->postal_code,
                'remark' => $logged_user->remark,
                'soap_note_link' => $logged_user->soap_note_link,
                'created_at' => get_formatted_date($logged_user->created_at, 'M d, Y h:iA'),
                'deleted_at' => get_formatted_date($logged_user->created_at, 'M d, Y h:iA')
            )
        );
        if(!empty($logged_user->deleted_at)) {
            $all_members[0]['deleted_at'] = get_formatted_date($logged_user->deleted_at, 'M d, Y h:iA');
        }
        else {
            $all_members[0]['deleted_at'] = '';
        }
        // As Family member with Self
        if($logged_user->family_id > 0) {
            $members = User::withTrashed()->where('family_id', $logged_user->family_id)->where('id', '<>', $logged_user->customer_id)->get();
        }
        else{
            $members = '';
        }

        // If Members available then list them in all_members Variable.
        if(!empty($members)) {
            $i = 1;
            foreach($members as $val) {
                $all_members[$i]['id'] = $val->id;
                $all_members[$i]['family_id'] = $val->family_id;
                $all_members[$i]['first_name'] = ucwords($val->first_name);
                $all_members[$i]['last_name'] = ucwords($val->last_name);
                $all_members[$i]['email'] = $val->email;
                $all_members[$i]['mobile'] = $val->mobile;
                $all_members[$i]['dob'] = $val->dob;
                $all_members[$i]['address'] = $val->address;
                $all_members[$i]['gender'] = $val->gender;
                $all_members[$i]['dependent'] = $val->dependent;
                $all_members[$i]['city'] = ucwords($val->city);
                $all_members[$i]['state'] = ucwords($val->state);
                $all_members[$i]['postal_code'] = $val->postal_code;
                $all_members[$i]['remark'] = $val->remark;
                $all_members[$i]['soap_note_link'] = $val->soap_note_link;
                $all_members[$i]['created_at'] = get_formatted_date($val->created_at, 'M d, Y h:iA');
                if(!empty($val->deleted_at)) {
                    $all_members[$i]['deleted_at'] = get_formatted_date($val->deleted_at, 'M d, Y h:iA');
                }
                else {
                    $all_members[$i]['deleted_at'] = '';
                }
                $i++;
            }
        }

        // Booking History of Profiled Person
        $bok_his = Booking::where('customer_id', $logged_user->customer_id)->orderBy('booking_date', 'DESC')->get();

        // add service name in $bok_his object array.
        $bok_his->map(function($bok_his){
            $serviceIds = explode(',', $bok_his->services); // Convert string into Array
            $serviceNames = Service::whereIn('id', $serviceIds)->pluck('service_name')->toArray();
            $bok_his->service_names = $serviceNames;
            return $bok_his;
        });
        // pr($bok_his); die;
        // pr($all_members); die;
        return view('admin.user.profile', compact('logged_user', 'all_members', 'logged_user_medical', 'bok_his'));
    }

    public function adminProfile(Request $request, $id)
    {
        $data = User::findOrFail($id);
        return view('admin.user.admin_profile', compact('data'));
    }

    public function updateAdminProfile(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'first_name' => 'required|string|min:2|max:20',
            'last_name' => 'required|string|min:2|max:20',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id)->whereNull('deleted_at'),
            ],
            'mobile' => [
                'nullable',
                'max:10',
                Rule::unique('users')->ignore($id)->whereNull('deleted_at'),
            ],
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        try {
            $profile = User::findOrFail($id);
            $profile->first_name = $request->first_name;
            $profile->last_name = $request->last_name;
            $profile->email = $request->email;
            $profile->mobile = $request->mobile;
            $profile->whatsapp_no = $request->whatsapp_no;
            if ($request->hasFile('profile_img')) {
                $profileImage = $request->file('profile_img');
                $profileImageName = time() . '_profile.' . $profileImage->getClientOriginalExtension();
                $profileImage->move(public_path('admin_assets/assets/img'), $profileImageName);
                $profile->profile_img = $profileImageName;
            }
            $profile->save();
            return redirect()->route('admin.profile', $id)->with('success', 'Profile updated Successfully');
        }
        catch(Exception $e) {
            return redirect()->back()->with('error', 'Sorry, Some technical issue for update '.$e->getMessage());
        }
    }

    /**
     * Update the Admin Password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id', // or admins table
            'password' => 'required|confirmed|min:8',
        ]);
        try {
            $user = User::findOrFail($request->id); 
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('admin.profile', $request->id)->with('success', 'Password Changed Successfully');
        }
        catch(Exception $e) {
            return redirect()->back()->with('error', 'Password could not changed due to some Technical Issue '.$e->getMessage());
        }
    }

    /**
     * Remove the specified client from database
     */
    public function delete(Request $request)
    {
        try {
            $client_id = $request->id;
            $customer = User::find($client_id);
            // $detail = Customer::where('id', $client_id)->first();
            if(!$customer) {
                return response()->json([
                    'status' => false,
                    'message' => 'Client not found'
                ]);
            }
            else {
                if($customer->family_id > 0){
                    User::where('family_id', $customer->family_id)->update(['family_id' => 0]);
                }
            }
            $customer->delete();
            return response()->json([
                'status' => true,
                'message' => 'Client deleted Successfully.'
            ]);
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'have some issue on deleting the Client '. $e->getMessage()]);
        }
    }

    /*public function deleteRelatedClient(Request $request) 
    {
        try {
            $customer = Customer::with('children')->find($request->id);
            if(!$customer) {
                return response()->json(['status' => false, 'message'=>'Client not found']);
            }

            // Delete Children First
            foreach($customer->children as $child) {
                $child->delete();
            }

            // find the user detail 
            $user = User::findOrFail($customer->user_id);

            // Delete Main Client Account and it's login detail.
            $customer->delete();
            $user->delete();

            return response()->json(['status' => true, 'message' => 'Client deleted with it\'s Family members']);

        }
        catch(Exception $e) {   
            return response()->json(['status' => false, 'message' => 'ohh Server is down, Please try after sometime '.$e->getMessage()]);
        }

    }*/

    /**
     * Family Members Listing
     */
    public function getFamilyMembers(Request $request, $id) 
    {
        try{
            $result = User::where('id', $id)->first();
            if(!empty($result->family_id)) {
                $all_members = User::where('family_id', $result->family_id)->orderBy('is_primary', 'DESC')->get();
            }
            else {
                $all_members[0] = $result;
            }
            return view('admin.user.members', compact('all_members'));
        }
        catch(Exception $e){
            return view('admin.user.members');
        }
    }

    /**
     * Show the Member Detail in a popup for edit or view.
     */
    public function memberDetail($id)
    {
        // echo $id.'<br>';echo $type;
        $data = User::where('id', $id)->first();
        if(!empty($data)) {
            // $data->dob = get_formatted_date($data->dob, 'M d, Y');
            return response()->json(['status'=>true, 'data'=>$data], 200);
        }
        else {
            return response()->json(['status'=>false, 'message'=>'No Data Found'], 400);
        }
    }

    /**
     * Update the member detail from above popup
    */
    public function updateMember(Request $request)
    {
        $id = $request['id'];
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $email = $request['email'];
        $mobile = $request['mobile'];
        // $dob = $request['dob'];
        $dt = $request['bday'];
        $mn = $request['bmonth'];
        $yr = $request['byear'];
        $address = $request['address'];
        $gender = $request['gender'];
        $dependent = $request['dependent'] ?? 'no';
        $city = $request['city'];
        $state = $request['state'];
        $postal_code = $request['postal_code'];
        $remark = $request['remark'];

        // Validate input
        $rules = [
            'first_name' => [
                'required',
                'min:2',
                'regex:/^[A-Za-z]+( [A-Za-z]+)*$/',
            ],
            'last_name' => [
                'required',
                'min:2',
                'regex:/^[A-Za-z]+$/',
            ],
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($id)->whereNull('deleted_at'),
            ],
            'mobile' => [
                'nullable',
                'regex:/^[0-9]{3}[-\s]?[0-9]{3}[-\s]?[0-9]{4}$/',
                Rule::unique('users', 'mobile')->ignore($id)->whereNull('deleted_at'),
            ],
            'gender' => [
                'required'
            ],
            'postal_code' => [
                'nullable',
                'regex:/^[A-Za-z0-9]{3}\s?[A-Za-z0-9]{3}$/',
            ]
        ];

        // CONDITIONAL VALIDATION BASED ON DEPENDENT VALUE
        if ($request->dependent === 'no') {
            $rules['email'][] = 'required';
            $rules['mobile'][] = 'required';
        }
        else if($request->dependent === 'yes') {
            $rules['email'][] = 'email';
            $rules['email'][] = Rule::unique('users', 'email')->ignore($id)->whereNull('deleted_at');
            $rules['mobile'][] = Rule::unique('users', 'mobile')->ignore($id)->whereNull('deleted_at');
        }
        $request->merge([
            'mobile' => str_replace([' ','-'], '', $request['mobile']),
            'postal_code' => str_replace(' ', '', $request['postal_code'])
        ]);
        $request->validate($rules);

        try {
            $user = User::findOrFail($id);
            $user->first_name = ucwords($first_name);
            $user->last_name = ucwords($last_name);
            $user->email = $email;
            $user->mobile = $request['mobile'];
            if(!empty($dt) & !empty($mn) && !empty($yr)) {
                $user->dob = get_formatted_date($yr.'-'.$mn.'-'.$dt, 'Y-m-d');
            }

            // get the DOB from medical form table. if not available then update Medical Form Table.
            $medical_detail = MedicalForm::where('customer_id', $id)->first();
            if ($medical_detail) {
                // 2. Compare the dates (standardizing format helps avoid strtotime mismatches)
                if ($medical_detail->dob !== $user->dob) {
                    $medical_detail->dob = $user->dob;
                    $medical_detail->save(); // 3. Only hits the DB if necessary
                }
            }
            
            $user->address = $address;
            $user->gender = $gender;
            $user->dependent = $dependent;
            $user->city = ucwords($city);
            $user->state = ucwords($state);
            $user->postal_code = $request['postal_code'];
            $user->remark = $remark;
            $user->save();
            return response()->json(['status' => true, 'message' => 'Record Updated Successfully!']);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Record Could not saved Due to some error '.$e->getMessage()]);
        }
    }

    /**
     * Add Family Member
    */
    public function addMember(Request $request)
    {
        $rules = [
            'first_name' => [
                'required',
                'min:2',
                'regex:/^[A-Za-z]+( [A-Za-z]+)*$/',
            ],
            'last_name' => [
                'required',
                'min:2',
                'regex:/^[A-Za-z]+$/', // only one word, alphabets only
            ],
            'email' => [
                'nullable',
                'email',
                'unique:users,email,NULL,id,deleted_at,NULL', // unique globally
            ],
            'mobile' => [
                'nullable',
                'regex:/^[0-9]{3}[-\s]?[0-9]{3}[-\s]?[0-9]{4}$/', // 10 digits with optional space/dash
                'unique:users,mobile,NULL,id,deleted_at,NULL', // unique globally
            ],
            'gender' => [
                'required'
            ],
            'postal_code' => [
                'nullable',
                'regex:/^[A-Za-z0-9]{3}\s?[A-Za-z0-9]{3}$/',
            ]
        ];

        if($request->dependent === 'no') {
            $rules['email'][] = 'required';
            $rules['mobile'][] = 'required';
            $rules['postal_code'][] = 'nullable';
        }

        $request->validate($rules);
        
        // Validate input

        $familyid = $this->getLastUsedFamilyId();
        if(!empty($familyid)) {
            $next_familyid = $familyid + 1;
            if(empty($request['family_id'])) {
                User::where('id', $request['parent_id'])->update(['family_id'=> $next_familyid]);    // update first user family id.
                $familyid = $next_familyid;
            }
            else {
                $familyid = $request['family_id'];
            }
        }
        else {
            $familyid = 1;
            User::where('id', $request['parent_id'])->update(['family_id'=> $familyid]);
        }
        // Normalize the mobile number
        $request->merge([
            'mobile' => str_replace([' ','-'], '', $request['mobile']),
            'postal_code' => str_replace(' ', '', $request['postal_code'])
        ]);

        try {
            DB::beginTransaction();
            $user = new User();
            $user->first_name = ucwords($request['first_name']);
            $user->last_name = ucwords($request['last_name']);
            $user->email = $request['email'];
            $user->mobile = $request['mobile'];
            if(!empty($request['bday']) && !empty($request['bmonth']) && !empty($request['byear'])) {
                $user->dob = get_formatted_date($request['bday'].'-'.$request['bmonth'].'-'.$request['byear'], 'Y-m-d');
            }
            
            $user->address = $request['address'];
            $user->gender = $request['gender'];
            $user->dependent = $request['dependent'];
            $user->is_primary = $request['is_primary'];
            $user->city = ucwords($request['city']);
            $user->state = ucwords($request['state']);
            $user->postal_code = $request['postal_code'];
            $user->remark = $request['remark'];
            $user->family_id = $familyid;
            // $user->status = 1;
            $user->save();
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Family Member added successfully!'],201);
        }
        catch(Exception $e) {
            DB::rollback();
            return response()->json(['status'=> false, 'error' => 'Family Member Could not be added due to some issue '. $e->getMessage()], 400);
        }
    }

    /**
     * Add Individual Person as Family Member
    */
    public function addIndividualPerson(Request $request)
    {
        $error_msg = [
            'member_id.required' => 'Please enter individual client name or mobile',
            'parent_id.required' => 'Parent Client Id is not present, Some error is here.',
            // You can add more custom messages for different rules or fields here
        ];
        $request->validate([
            'member_id' => 'required',
            'parent_id' => 'required'
        ]);

        try {
            // if first person have not the family id then next family id will be used
            $data = User::where('id', $request->parent_id)->first(['family_id']);
            if($data->family_id == 0) {
                $familyid = $this->getLastUsedFamilyId();
                if(!empty($familyid)) {
                    $next_familyid = $familyid + 1;
                    User::where('id', $request->parent_id)->update(['family_id' => $next_familyid]);
                    $member_detail = User::where('id', $request->member_id)->first();
                    $depend = 'yes';
                    if(!empty($member_detail->email) && !empty($member_detail->mobile)) {
                        $depend = 'no';
                    }
                    User::where('id', $request->member_id)->update(['family_id' => $next_familyid, 'dependent' => $depend, 'is_primary' => 0]);

                    return response()->json(['status' => true, 'message' => 'Existing Individual now is the family member']);
                }
            }
            else {
                // if first person have the family id then that family id will be used
                $member_detail = User::where('id', $request->member_id)->first();
                $depend = 'yes';
                if(!empty($member_detail->email) && !empty($member_detail->mobile)) {
                    $depend = 'no';
                }
                User::where('id', $request->member_id)->update(['family_id' => $data->family_id, 'dependent' => $depend, 'is_primary' => 0]);

                return response()->json(['status' => true, 'message' => 'Existing Individual now is the family member']);
            }
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'msg' => 'Something went wrong, '.$e->getMessage()]);
        }
    }

    /**
     * Search The Customer By Name or mobile Number
    */
    public function searchCustomer(Request $request)
    {
        // pr($request->get('query'));die('test');
        $searchTerm = $request->get('query');
        $data = User::where('role', 'customer')
            ->where(function ($query) use ($searchTerm) {
                $query->where('first_name', 'like', "%$searchTerm%")
                    ->orWhere('last_name', 'like', "%$searchTerm%")
                    ->orWhereRaw("CONCAT(first_name,' ',last_name) LIKE ?",["%{$searchTerm}%"])
                    ->orWhere('mobile', 'like', "%$searchTerm%");
                })
            ->get(['id','first_name', 'last_name','mobile','email', 'family_id']);
        return response()->json(['status' => true, 'data' => $data], 200);
    }

    /**
     * Search Individual Customers
    */
    public function searchIndividualCustomer(Request $request)
    {
        $query = $request->get('query');
        $data = User::where(function ($q) use ($query) {
                    $q->where('first_name', 'like', "%$query%")
                    ->orWhere('last_name', 'like', "%$query%")
                    ->orWhereRaw("CONCAT(first_name,' ',last_name) LIKE ?", ["%{$query}%"])
                    ->orWhere('mobile', 'like', "%$query%");
                })
                ->where(function ($q) {
                    $q->where('family_id', 0)->orWhereNull('family_id');
                })
                ->get();
        // $sql = $data->toSql();
        // dump($sql);
        if(!empty($data)) {
            return response()->json(['status' => true, 'data' => $data], 200);
        }
        else {
            return response()->json(['status' => false, 'message' => 'Result Not Found'], 404);
        }
    }

    public function getFamilyEmail(Request $request)
    {
        $data = User::where('family_id', $request->family_id)->where('email', '<>', '')->where('family_id', '<>', null)->where('family_id', '<>', '0')->first(['email']);
        if(!empty($data->email)) {
            return response()->json(['status' => true, 'email' => $data->email]);
        }
        else {
            return response()->json(['status' => true, 'email' => '']);
        }
        
    }

    public function getFamilyMobile(Request $request)
    {
        $data = User::where('family_id', $request->family_id)->where('mobile', '<>', '')->where('family_id', '<>', null)->where('family_id', '<>', '0')->first(['mobile']);
        if(!empty($data->mobile)) {
            return response()->json(['status' => true, 'mobile' => $data->mobile]);
        }
        else {
            return response()->json(['status' => true, 'mobile' => '']);
        }
    }

    /**
     * 
    */
    public function removeMember(Request $request)
    {
        // echo $client_id = $request->id;die;
        try{
            $data = User::where('id', $request->id)->first(['family_id']);
            // pr($data->toArray()); die;
            $person_count = User::where('family_id', $data->family_id)->count();
            if($person_count <= 2 && $data->family_id > 0)  {
                User::where('family_id', $data->family_id)->update(['family_id' => 0, 'dependent' => 'no', 'is_primary' => 1]);
            }
            else {
                User::where('id', $request->id)->update(['family_id' => 0, 'dependent' => 'no', 'is_primary' => 1]);
            }
            
            return response()->json(['status' => true, 'msg' => 'Member Removed Successfully'], 200);
        }
        catch(Exception $e) {
            return response()->json(['status'=> false, 'error' => 'Member Could not be removed Due to '. $e->getMessage()], 400);
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

    public function changeParent(Request $request)
    {
        try{
            $main_detail = User::find($request->main_parent); // Main Parent Detail
            $changed_to_detail = User::find($request->make_parent); // Become Primary
            /*if($changed_to_detail->email == '') {
                $changed_to_detail->email = $main_detail->email;
                $main_detail->email = null;

            }
            if($changed_to_detail->mobile == '') {
                $changed_to_detail->mobile = $main_detail->mobile;
                $main_detail->mobile = null;
            }*/

            $changed_to_detail->is_primary = 1;
            $main_detail->is_primary = 0;

            /*$changed_to_detail->dependent = 'no';
            
            if($main_detail->email == null || $main_detail->mobile == null) {
                $main_detail->dependent = 'yes';
            }
            else {
                $main_detail->dependent = 'no';
            }*/

            // $changed_to_detail->password = $main_detail->password;
            /*if($changed_to_detail->dependent == 'yes') {
                $changed_to_detail->dependent = 'no';
                $main_detail->dependent = 'yes';
            }*/

            $changed_to_detail->save();

            $main_detail->save();

            return response()->json(['status' => true, 'message' => 'Parent updated Successfully']);
        }
        catch(Exception $e) {
            return response()->json(['status' => true, 'message' => 'Action could not be update because of '.$e->getMessage()]);
        }
    }

    public function downloadMedicalDetail($id) 
    {
        $data = MedicalForm::where('customer_id', $id)->first();
        if($data) {
            $pdf = Pdf::loadView('pdf.medical-form-pdf', ['data' => $data]);
            return $pdf->download('medical-detail.pdf');
        }
        else {
            return back()->with('error', 'No records found.');
        }
    }
}