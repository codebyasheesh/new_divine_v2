<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmailTemplateController extends Controller
{
    /**
     * Show the Email template listing page
     */
    public function index()
    {
        return view('admin.emailtemplates.index');
    }

    /**
     * List the email templates by ajax request
     */
    public function list(Request $request)
    {
        if($request->ajax()) {
            $query = EmailTemplate::select(['id','template_key', 'template_name','subject', 'status']);

            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('status', function ($row){
                $update_status = "updateEmailTemplateStatus('".$row->id."')";
                $isChecked = ($row->status == 1) ? 'checked': '';
                $switchColorClass = ($row->status == 1) ? 'form-switch-success' : 'form-switch-danger';
                $tooltip_title = ($row->status == 1) ? 'Active':'Inactive';
                $switchId = 'emailTempStatusSwitch_'.$row->id;
                return '<div class="form-check form-switch '.$switchColorClass.' ms-2">
                    <input class="form-check-input" id="'.$switchId.'" 
                        data-bs-toggletip="tooltip" data-bs-title="'.$tooltip_title.'" 
                        type="checkbox" role="switch" '.$isChecked.' 
                        onclick="'.$update_status.'">
                </div>';
            })
            ->addColumn('action', function($row){
                $delete_emtemp = "deleteEmailTemplate('".$row->id."')";
                $edit_template = route('admin.edit.email.template', $row->id);
                $action_group = '<div class="btn-group btn-sm">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                      </button>
                      <ul class="dropdown-menu" style="">
                        <li><a class="dropdown-item" href="'. $edit_template .'"><i class="bi bi-eye"></i> Edit</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="'.$delete_emtemp.'" data-bs-toggletip="tooltip" data-bs-title="Delete Email Template"><i class="bi bi-trash"></i> Delete</a></li>
                      </ul>
                    </div>';
                    return $action_group;
                // return '<div class="d-flex align-items-center">
                //     <a href="javascript:void(0);" onclick="'.$delete_emtemp.'" class="btn btn-sm btn-danger" data-bs-toggletip="tooltip" data-bs-title="Delete Email Template"><i class="bi bi-trash"></i> Delete</a>
                // </div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
        }
    }

    public function add()
    {
        return view('admin.emailtemplates.add');
    }

    /**
     * Save the template in the Table
     * @request
     */
    public function save(Request $request)
    {
        $request->validate([
            'template_name' => 'required',
            'template_key' => 'required|unique:email_templates,template_key',
            'subject' => 'required',
            'body' => 'required'
        ]);
        try{
            $template = new EmailTemplate();
            $template->template_name = $request->template_name;
            $template->template_key = $request->template_key;
            $template->subject = $request->subject;
            $template->body  = $request->body;
            $template->save();
            return redirect()->route('admin.email.templates')->with('success', 'Template created Successfully');
        }
        catch(Exception $e) {
            return redirect()->back()->with('error', 'Failed to create email template: ' . $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $data = EmailTemplate::findOrFail($request->id);
        
        return view('admin.emailtemplates.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'template_name' => 'required',
            // 'template_key' => 'required|unique:email_templates,template_key,'.$request->id,
            'subject' => 'required',
            'body' => 'required'
        ]);

        try{
            $data = EmailTemplate::findOrFail($request->id);
            $data->template_name = $request->template_name;
            $data->subject = $request->subject;
            $data->body = $request->body;
            $data->save();
            return redirect()->route('admin.email.templates')->with('success', 'Template updated Successfully');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Failed to create email template: ' . $e->getMessage());
        }
    }
}
