<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    //
    public function index(Request $request, $id)
    {
        $client_level = Customer::where('id', $id)->first(['user_id', 'parent_id']);
        // if clicked user is child
        if($client_level->user_id == 0) {
            $parent = Customer::where('id', $client_level->parent_id)->first();
            $members = Customer::where('parent_id', $client_level->parent_id)->get();
        }
        // If Clicked User Is Parent.
        if($client_level->user_id != 0)
        {
            $parent = Customer::where('id', $id)->first();
            $members = Customer::where('parent_id', $id)->get();
        }

        $all_members = array(
            array(
                'id' => $parent->id,
                'name' => $parent->name,
                'email' => $parent->email,
                'mobile' => $parent->mobile,
                'address' => $parent->address,
                'user_id' => $parent->user_id,
                'parent_id' => $parent->parent_id,
                'status' => $parent->status
            )
        );

        if(!empty($members)) {
            $i = 1;
            foreach($members as $val) {
                $all_members[$i]['id'] = $val->id;
                $all_members[$i]['name'] = $val->name;
                $all_members[$i]['email'] = $val->email;
                $all_members[$i]['mobile'] = $val->mobile;
                $all_members[$i]['address'] = $val->address;
                $all_members[$i]['user_id'] = $val->user_id;
                $all_members[$i]['parent_id'] = $val->parent_id;
                $all_members[$i]['status'] = $val->status;
                $i++;
            }
        }
        return view('admin.customer.index', compact('all_members'));
    }

    /*public function add(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:40',
            'email' => 'required|email|unique:customers,email',
            'mobile' => 'required|string|max:10|unique:customers,mobile',
        ]);

        try {
            DB::beginTransaction();
            $customer = new Customer();
            $customer->name = $request['customer_name'];
            $customer->email = $request['email'];
            $customer->mobile = $request['mobile'];
            $customer->address = $request['address'];
            $customer->user_id = 0;
            $customer->parent_id = $request['parent_id'];
            $customer->status = 1;
            $customer->save();
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Family Member added successfully!'],201);
        }
        catch(Exception $e) {
            DB::rollback();
            return response()->json(['status'=> false, 'error' => 'Family Member Could not be added due to some issue '. $e->getMessage()], 400);
        }
    }*/
    
    /*public function view(Request $request, $id, $type)
    {
        // echo $id.'<br>';echo $type;
        $data = Customer::where('id', $id)->first();
        if(!empty($data)) {
            return response()->json(['status'=>true, 'data'=>$data], 200);
        }
        else {
            return response()->json(['status'=>false, 'message'=>'No Data Found'], 400);
        }
    }*/
    
    /*public function update(Request $request)
    {
        $id = $request['id'];
        $name = $request['customer_name'];
        $email = $request['email'];
        $mobile = $request['mobile'];
        $dob = $request['dob'];
        $address = $request['address'];

        // Validate input
        $request->validate([
            'customer_name' => 'required|string|max:40',
            'email' => [
                'required',
                'email',
                Rule::unique('customers')->ignore($id),
            ],
            'mobile' => [
                'required',
                'max:40',
                Rule::unique('customers')->ignore($id),
            ],
        ]);

        try {
            $customer = Customer::findOrFail($id);
            $customer->name = $name;
            $customer->email = $email;
            $customer->mobile = $mobile;
            $customer->address = $address;
            $customer->save();
            return response()->json(['status' => true, 'message' => 'Record Updated Successfully!']);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Record Could not saved Due to some error '.$e->getMessage()]);
        }
    }*/

    /**
     * Search The Customer By Name or mobile Number
     */
    /*public function searchCustomer(Request $request)
    {
        // pr($request->get('query'));die('test');
        $query = $request->get('query');
        $data = Customer::where('name', 'like', "%$query%")->orWhere('mobile', 'like', "%$query%")->get(['id','name','mobile','email']);
        if(!empty($data)) {
            return response()->json(['status' => true, 'data' => $data], 200);
        }
        else {
            return response()->json(['status' => false, 'message' => 'Result Not Found'], 404);
        }
        
    }*/
}
