<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DateOverride;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DateOverrideController extends Controller
{
    public function index()
    {
        return view('admin.schedule.date_override');
    }

    public function list(Request $request)
    {
        if($request->ajax()) {
            $query = DateOverride::select();
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('custom_date', function ($row) {
                return get_formatted_date($row->date, 'M d, Y');
            })
            ->addColumn('custom_start_time', function($row) {
                if(!empty($row->custom_start_time)) {
                    return get_formatted_date($row->custom_start_time, 'h:i A');
                }
                else {
                    return 'N/A';
                }
            })
            ->addColumn('custom_end_time', function($row) {
                if(!empty($row->custom_end_time)) {
                    return get_formatted_date($row->custom_end_time, 'h:i A');
                }
                else {
                    return 'N/A';
                }
            })
            ->addColumn('is_closed', function($row) {
                if($row->is_closed == 1) {
                    return '<div><span class="badge text-bg-danger">Yes</span></div>';
                }
                else {
                    return '<div><span class="badge text-bg-warning">No</span></div>';
                }
            })
            ->addColumn('action', function($row){
                // $delete_client = "deleteClient('".$row->id."')";
                $delete_blocktm = "deleteOverrideTime('".$row->id."')";
                
                return '<div class="d-flex align-items-center">
                    <a href="javascript:void(0);" onclick="'.$delete_blocktm.'" class="btn btn-sm btn-danger" data-bs-toggletip="tooltip" data-bs-title="Delete Blocking"><i class="bi bi-trash"></i> Delete</a>
                </div>';
            })
            ->rawColumns(['custom_date', 'is_closed', 'action'])
            ->make(true);
        }
    }

    public function add(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'is_closed' => 'required'
        ]);

        $objOverride = new DateOverride();
        $objOverride->date = get_formatted_date($request->date, 'Y-m-d');
        $objOverride->is_closed = $request->is_closed;
        if(!empty($request->cus_start_time)) {
            $objOverride->custom_start_time = $request->cus_start_time;
        }
        if(!empty($request->cus_end_time)) {
            $objOverride->custom_end_time = $request->cus_end_time;
        }
        $objOverride->save();
        return response()->json([
            'status' => true,
            'message' => 'Date override add successfully.',
        ]);
    }

    public function delete(Request $request)
    {
        $data = DateOverride::where('id', $request->id)->first();
        if($data) {
            $data->delete();
            return response()->json(['status' => true, 'message' => 'Date Override record delete successfully']);
        }
        else {
            return response()->json(['status' => true, 'message' => 'Record not found']);
        }
    }
}
