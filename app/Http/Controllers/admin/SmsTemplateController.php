<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SmsTemplate;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SmsTemplateController extends Controller
{
    public function index()
    {
        return view('admin.smstemplates.index');
    }

    /**
     * List the email templates by ajax request
     */
    public function list(Request $request)
    {
        if($request->ajax()) {
            $query = SmsTemplate::select(['id','sms_key', 'template_name', 'body', 'status']);

            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('status', function ($row){
                $update_status = "updateSmsTemplateStatus('".$row->id."')";
                $isChecked = ($row->status == 1) ? 'checked': '';
                $switchColorClass = ($row->status == 1) ? 'form-switch-success' : 'form-switch-danger';
                $tooltip_title = ($row->status == 1) ? 'Active':'Inactive';
                $switchId = 'smsTempStatusSwitch_'.$row->id;
                return '<div class="form-check form-switch '.$switchColorClass.' ms-2">
                    <input class="form-check-input" id="'.$switchId.'" 
                        data-bs-toggletip="tooltip" data-bs-title="'.$tooltip_title.'" 
                        type="checkbox" role="switch" '.$isChecked.' 
                        onclick="'.$update_status.'">
                </div>';
            })
            ->addColumn('action', function($row){
                $delete_smstemp = "deleteSmsTemplate('".$row->id."')";
                $edit_template = "editSmsTemplate('".$row->id."')";
                $action_group = '<div class="btn-group btn-sm">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                      </button>
                      <ul class="dropdown-menu" style="">
                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="'.$edit_template.'" data-bs-toggletip="tooltip" data-bs-title="Edit SMS Template" data-bs-toggle="modal" data-bs-target="#editSMSTemplatePop"><i class="bi bi-eye"></i> Edit</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="'.$delete_smstemp.'" data-bs-toggletip="tooltip" data-bs-title="Delete Email Template"><i class="bi bi-trash"></i> Delete</a></li>
                      </ul>
                    </div>';
                    return $action_group;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
        }
    }

    /**
     * Save the template in the Table
     * @request
     */
    public function save(Request $request)
    {
        $request->validate([
            'template_name' => 'required',
            'sms_key' => 'required|unique:sms_templates,sms_key',
            'body' => 'required'
        ]);
        try{
            $template = new SmsTemplate();
            $template->template_name = $request->template_name;
            $template->sms_key = $request->sms_key;
            $template->body  = $request->body;
            $template->save();
            return response()->json(['status' => true, 'message' => 'Sms Template added Successfully']);
            // return redirect()->route('admin.sms.templates')->with('success', 'Template created Successfully');
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Sms Template could not be added due to '.$e->getMessage()]);
            // return redirect()->back()->with('error', 'Failed to create sms template: ' . $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $data = SmsTemplate::findOrFail($request->id);
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'template_name' => 'required',
            'sms_key' => 'required|unique:sms_templates,sms_key,'.$request->id,
            'body' => 'required'
        ]);

        try{
            $data = SmsTemplate::findOrFail($request->id);
            $data->template_name = $request->template_name;
            $data->sms_key = $request->sms_key;
            $data->body = $request->body;
            $data->save();
            return response()->json(['status' => true, 'message' => 'Template updated Successfully']);
        }
        catch(Exception $e){
            return response()->json(['status'=> false, 'error' => 'Failed to create sms template: ' . $e->getMessage()]);
        }
    }
}
