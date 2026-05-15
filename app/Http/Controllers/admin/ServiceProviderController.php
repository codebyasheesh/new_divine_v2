<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceProvider;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ServiceProviderController extends Controller
{
    public function index()
    {
        return view('admin.service_provider.index');
    }

    public function list(Request $request)
    {
        if($request->ajax()) {
            $query = ServiceProvider::select(['id', 'first_name', 'last_name', 'email','mobile','title','license', 'status']);
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('name', function ($row){
                    // $profile_url = route('admin.userprofile', $row->id);

                    $first = $row->first_name ?? '';
                    $last = $row->last_name ?? '';
                    if(empty($last)) {
                        $full_name = trim($first);
                    }
                    else {
                        $full_name = trim("$last, $first");
                    }
                    return '<a class="link-underline-light" href="#">'.$full_name.'</a>';
                })
            ->addColumn('mobile', function($row) {
                if(strlen($row->mobile) === 10) {
                    return substr($row->mobile, 0, 3).'-'.substr($row->mobile, 3, 3).'-'.substr($row->mobile, 6, 4);
                }
            })
            ->addColumn('status', function ($row){
                $update_status = "updateProviderStatus('".$row->id."')";
                $isChecked = ($row->status == 1) ? 'checked': '';
                $switchColorClass = ($row->status == 1) ? 'form-switch-success' : 'form-switch-danger';
                $tooltip_title = ($row->status == 1) ? 'Active':'Inactive';
                $switchId = 'providerStatusSwitch_'.$row->id;
                return '<div class="form-check form-switch '.$switchColorClass.' ms-2">
                    <input class="form-check-input" id="'.$switchId.'" 
                        data-bs-toggletip="tooltip" data-bs-title="'.$tooltip_title.'" 
                        type="checkbox" role="switch" '.$isChecked.' 
                        onclick="'.$update_status.'">
                </div>';
            })
            ->filter(function ($query) use ($request) {
                // GLOBAL SEARCH (FROM DATATABLE SEARCH BOX)
                if ($request->has('search') && $request->search['value'] !== '') {

                    $search = $request->search['value'];

                    $query->where(function ($q) use ($search) {
                        $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email',      'like', "%{$search}%")
                        ->orWhere('mobile',     'like', "%{$search}%");
                    });
                }
            })
            ->addColumn('action', function($row){
                // $delete_client = "deleteClient('".$row->id."')";
                $edit_detail = "viewProviderDetail('".$row->id."')";
                
                return '<a href="javascript:void(0);" onclick="'.$edit_detail.'" class="btn btn-sm btn-success me-1" data-bs-toggle="modal" data-bs-target="#editServiceProviderPop" data-bs-whatever="editServiceProviderPop"
                role="button" data-bs-toggletip="tooltip" data-bs-title="Edit Service Provider"><i class="bi bi-pencil-square"></i> Edit</a>';
            })
            ->rawColumns(['name','mobile','status', 'action'])
            ->make(true);
        }
    }

    public function add(Request $request) 
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
                'required',
                'email',
                'unique:users,email,NULL,id,deleted_at,NULL', // unique globally
            ],
            'mobile' => [
                'required',
                'regex:/^[0-9]{3}[-\s]?[0-9]{3}[-\s]?[0-9]{4}$/', // 10 digits with optional space/dash
                'unique:users,mobile,NULL,id,deleted_at,NULL', // unique globally
            ],
            'title' => [
                'required'
            ],
            'license' => [
                'required'
            ]
        ];
        // pr($request->toArray()); die;
        $request->merge([
            'mobile' => str_replace([' ','-'], '', $request['mobile'])
        ]);
        $request->validate($rules);
        // $setting = getSetting();
        // pr($request->toArray()); die;
        try {
            DB::beginTransaction();
            $user = new User();
            $user->first_name = ucwords($request->first_name);
            $user->last_name = ucwords($request->last_name);
            $user->is_primary = 1;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->email_verify_token = uniqid();
            $user->password = Hash::make($request->mobile); // mobile will be used for password
            $user->role = 'provider';
            $user->dependent = 'no';
            $user->save();
            
            $provider = new ServiceProvider();
            $provider->first_name = ucwords($request->first_name);
            $provider->last_name =  ucwords($request->last_name);
            $provider->email = $request->email;
            $provider->mobile = $request->mobile;
            $provider->title = $request->title;
            $provider->license = $request->license;
            $provider->user_id = $user->id;
            $provider->save();
            
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Service provider added successfully!'], 201);
        }
        catch(Exception $e) {
            //throw $th;
            DB::rollback();
        }
    }

    public function view(Request $request)
    {
        try{
            $data = ServiceProvider::findOrFail($request->id);
            return response()->json(['status' => 200, 'data' => $data]);
        }
        catch(Exception $e) {
            return response()->json(['status' => 404, 'message' => 'Data could not fetched due to '.$e->getMessage()]);
        }
        
    }

    public function update(Request $request)
    {
        $provider = ServiceProvider::findOrFail($request->id);
        // Fetch Corresponding User Detail
        $user = User::where('id', $provider->user_id)->firstOrFail();

        // Validation
        $request->validate([
            'first_name' => 'required|max:30',
            'last_name'  => 'required|max:20',

            'email' => [
                'required',
                'email',
                // unique in users table except current user
                Rule::unique('users', 'email')->ignore($user->id)->whereNull('deleted_at'),
                // unique in service_providers except current provider
                Rule::unique('service_providers', 'email')->ignore($provider->id),
            ],

            'mobile' => [
                'required',
                'digits:10',
                Rule::unique('users', 'mobile')->ignore($user->id)->whereNull('deleted_at'),
                Rule::unique('service_providers', 'mobile')->ignore($provider->id),
            ],

            'title'      => 'required|string|max:40',
            'license' => 'required|string|max:20',
        ]);

        DB::beginTransaction();
        try{
            // Update service provider
            $provider->first_name = $request->first_name;
            $provider->last_name = $request->last_name;
            $provider->email = $request->email;
            $provider->mobile = $request->mobile;
            $provider->title = $request->title;
            $provider->license = $request->license;
            $provider->save();

            // Update user table
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->save();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Service Provider updated successfully.'
            ]);
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        try{
            $provider = ServiceProvider::find($request->id);
            if(!$provider) {
                return response()->json(['status' => false, 'msg' => 'Service not found.'], 404);
            }
            $msg = '';
            if($provider->status == 0)
            {
                $provider->status = 1;
                $provider->save();
                $msg = 'Service Provider <span class="text-success">Activated</span> Successfully';
                return response()->json(['status' => true, 'msg' => $msg, 'cls'=>'ac']);
            }
            if($provider->status == 1) {
                $provider->status = 0;
                $provider->save();
                $msg = 'Service Provider <span class="text-danger">Inactive</span> Now';
                return response()->json(['status' => true, 'msg' => $msg, 'cls'=>'inac']);
            }
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'msg' => 'System have some issue Please try after some time. '.$e->getMessage()], 500);
        }
    }
}
