<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    /**
     * Show the listing of services
     */
    public function index()
    {
        $parent_services = Service::where('parent_id', '0')->get(['id','service_name']);
        return view('admin.service.index', compact('parent_services'));
    }

    public function getServicesList(Request $request)
    {
        if ($request->ajax()) {
            // Get all services once
            $allServices = Service::orderBy('service_name', 'asc')->get();

            // Flatten them with hierarchy levels
            $services = $this->buildServiceTree($allServices);

            return DataTables::of($services)
                ->addIndexColumn()
                ->addColumn('service_name', function($row) {
                    $indent = str_repeat('&nbsp;&nbsp;&nbsp;', $row->level); // indentation
                    if ($row->parent_id == 0) {
                        return $indent . $row->service_name . ' (<span class="text-success fw-bold">Parent</span>)';
                    }
                    return $indent . $row->service_name;
                })
                ->addColumn('action', function($row){
                    $edit_detail = "viewServiceDetail('".$row->id."')";
                    $update_status = "updateServiceStatus('".$row->id."')";
                    $delete_service = "deleteService('".$row->id."')";
                    $isChecked = $row->status ? 'checked': '';
                    $switchColorClass = $row->status ? 'form-switch-success' : 'form-switch-danger';
                    $tooltip_title = $row->status ? 'Active':'Inactive';
                    $switchId = 'serviceStatusSwitch_'.$row->id;

                    return '<div class="d-flex align-items-center">
                                <a href="javascript:void(0);" onclick="'.$edit_detail.'" class="btn btn-sm btn-primary" 
                                data-bs-toggletip="tooltip" data-bs-title="Edit Service" 
                                data-bs-toggle="modal" data-bs-target="#editServicePop" role="button">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <div class="form-check form-switch '.$switchColorClass.' ms-2">
                                    <input class="form-check-input" id="'.$switchId.'" 
                                        data-bs-toggle="tooltip" data-bs-title="'.$tooltip_title.'" 
                                        type="checkbox" role="switch" '.$isChecked.' 
                                        onclick="'.$update_status.'">
                                </div>
                                <a href="javascript:void(0);" onclick="'.$delete_service.'" class="btn btn-sm btn-danger" data-bs-toggletip="tooltip" data-bs-title="Delete Service"><i class="bi bi-trash"></i> Delete</a>
                            </div>';
                })
                ->rawColumns(['service_name','action'])
                ->make(true);
        }
    }

    public function add(Request $request)
    {
        // Validate the input request 
        // pr($request); die;
        $request->validate([
            'parent_service' => 'nullable|numeric',
            'service_name' => 'required|string|max:50',
            // 'duration'     => 'required_if:parent_service,!null|integer|min:0',
            'duration'     => 'nullable',
            'price'        => 'required_if:parent_service,!null|numeric|min:1',
        ],
        [
            'duration' => 'Please enter the Service Duration',
            'price' => 'Please enter the Price of Service'
        ]);
        // die('dfsdf');
        // Check for duplicate service name (case-insensitive)
        $exists = Service::whereRaw('LOWER(service_name) = ?', [strtolower($request->service_name)])->whereNull('deleted_at')->exists();

        if ($exists) {
            return response()->json([
                'status' => '409',
                'message' => 'Service name already exists.',
            ], 409); // HTTP 409 Conflict
        }

        // Save New Service Name
        $service = new Service();
        if(!empty($request['duration'])) { $duration = $request['duration']; }
        else { $duration = 0; }
        $service->parent_id = $request['parent_service'] ?? 0;
        $service->service_name = $request['service_name'];
        $service->duration = ($request['parent_service'])? $duration : 0;
        $service->price = ($request['parent_service'])?$request['price']:0;
        $service->is_taxable = $request->is_taxable;
        $service->save();

        return response()->json([
            'status' => 201,
            'message' => 'Service created successfully.',
            'data' => $service
        ], 201);
    }

    /**
     * Show the particular Service Detail in POP UP for Edit the detail and update.
     */
    public function showService(Request $request)
    {
        $id = $request->get('id');
        $data = Service::where('id', $id)->first(['id','service_name', 'parent_id','duration','price','is_taxable'])->toArray();
        
        return response()->json([
            'code'=>'200',
            'data' => $data
        ]);

    }

    public function updateService(Request $request)
    {
        $id = $request->post('id');
        $parent_service = $request->post('parent_service') ?? 0;
        $name = $request->post('service_name');
        $duration = $request->post('duration');
        $price = $request->post('price');
        $is_taxable = $request->post('is_taxable');

        $validator = Validator::make($request->all(), [
            'parent_service' => 'nullable|numeric',
            'service_name' => 'required|unique:services,service_name,'.$id,
            'duration' => 'required_if:parent_service,!null',
            'price' => 'required_if:parent_service,!null'
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 400, 'errors' => $validator->messages(), 'message' => 'Validation Fails']);
        }
        else
        {
            $model = Service::find($id);
            $model->parent_id = $parent_service;
            $model->service_name = $name;
            $model->duration = ($parent_service)?$duration:0;
            $model->price = ($parent_service)?$price:0;
            $model->is_taxable = ($parent_service)?$is_taxable:0;

            $done = $model->save();
            if($done) {
                $msg = 'Service Detail Updated Successfully';
                return response()->json([
                    'status' => 200,
                    'message' => $msg
                ]);
            }
            else {
                $msg = 'Oops, Something wrong here. Please try again';
                return response()->json([
                    'status' => 404,
                    'message' => $msg
                ]);
            }
        }
    }

    /**
     * Update the status of Service
     * if Status of Parent service is updated then all child status will also updated and if child status is updated then only that service status will update
     */
    public function updateStatus(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:services,id', // Ensure 'id' is present, integer, and exists in 'services' table
        ]);

        try{
            $service = Service::find($validatedData['id']);
            if(!$service) {
                return response()->json(['status' => false, 'msg' => 'Service not found.'], 404);
            }
            $msg = '';
            if($service->status == 0)
            {
                $service->status = 1;
                // If Parent Status update
                if($service->parent_id == 0) {
                    Service::where('parent_id', $service->id)->update(['status'=> 1]);
                }
                $msg = 'Service <span class="text-success">Activated</span> Successfully';
                $service->save();
                return response()->json(['status' => true, 'msg' => $msg, 'cls'=>'ac']);
            }
            if($service->status == 1) {
                $service->status = 0;
                // If Parent Status update
                if($service->parent_id == 0) {
                    Service::where('parent_id', $service->id)->update(['status'=> 0]);
                }
                $msg = 'Service <span class="text-danger">Inactive</span> Now';
                $service->save();
                return response()->json(['status' => true, 'msg' => $msg, 'cls'=>'inac']);
            }
            
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'msg' => 'System have some issue Please try after some time. '.$e->getMessage()], 500);
        }
    }

    public function servicePrice(Request $request)
    {
        $service_id = $request->get('service_id');
        $data = Service::where('id', $service_id)->first();
        return response()->json(['status' => true, 'data' => $data]);
    }

    /**
     * This method is used for show parent child sequence in datatable listing.
     */
    private function buildServiceTree($services, $parentId = 0, $level = 0, &$result = [])
    {
        foreach ($services as $service) {
            if ($service->parent_id == $parentId) {
                $service->level = $level;
                $result[] = $service;
                $this->buildServiceTree($services, $service->id, $level + 1, $result);
            }
        }
        return $result;
    }

    public function destroy(Request $request)
    {
        try {
            $service_id = $request->id;
            $service = Service::with('children')->find($service_id);
            if(!$service) {
                return response()->json([
                    'status' => false,
                    'message' => 'Service not found'
                ]);
            }

            if($service->parent_id != 0) {
                // It is a child and can delete directly
                $service->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Service deleted Successfully.'
                ]);
            }

            if($service->parent_id == 0) {
                // if requested id have login then get it's children
                $child_ids = $service->children->pluck('id')->toArray();
                return response()->json([
                    'status' => 'confirm',
                    'message' => 'This service has at least one child service. Deleting it will also delete all child services',
                    'children' => $child_ids
                ]);
            }

        }
        catch(Exception $e){
            return response()->json(['status' => false, 'message' => 'have some issue on deleting the Service '. $e->getMessage()]);
        }
    }

    public function destroyAll(Request $request)
    {
        try{
            $service_id = $request->id;
            $service = Service::with('children')->find($service_id);
            if(!$service) {
                return response()->json([
                    'status' => false,
                    'message' => 'Service not found'
                ]);
            }

            // Delete Children First
            foreach($service->children as $child) {
                $child->delete();
            }

            $service->delete();

            return response()->json(['status' => true, 'message' => 'Service deleted with it\'s Child Service Name']);
        }
        catch(Exception $e){
            return response()->json(['status' => false, 'message' => 'ohh Server is down, Please try after sometime '.$e->getMessage()]);
        }
    }
}

