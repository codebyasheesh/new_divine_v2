<?php

namespace App\Http\Controllers\admin;

use App\Models\HolidayList;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HolidayListController extends Controller
{
    // View the index page for display Holiday List
    public function index()
    {
        return view('admin.holiday.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $holidays = HolidayList::orderByDesc('created_at');
            return DataTables::of($holidays)
                ->addIndexColumn()
                
                ->addColumn('action', function ($holiday) {
                    $edit_detail = "viewHolidayDetail('".$holiday->id."')";
                    $delete_holiday = "deleteHoliday('".$holiday->id."')";
                    $action = '<div class="d-flex justify-content-center">';
                    $action .= '<a href="javascript:void(0);" onclick="'.$edit_detail.'" class="btn btn-sm btn-success me-1" data-bs-toggle="modal" data-bs-target="#editHolidayPop" data-bs-whatever="editHolidayPop"
                    role="button" data-bs-toggletip="tooltip" data-bs-title="Edit Holiday"><i class="bi bi-pencil-square"></i> Edit</a>
                    <a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="' .$delete_holiday. '"><i class="bi bi-trash"></i> Delete</a>';
                    $action .= '</div>';
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Add Holiday
    */
    public function add(Request $request)
    {
        $request->validate([
            'holiday_name' => 'required',
            'st_dt' => 'required',
            'ed_dt' => 'required'
        ]);
        
        try{
            $start_dt = $request->st_dt;
            $end_dt = $request->ed_dt;
            $holiday_name = $request->holiday_name;

            $objHoliday = new HolidayList();
            $objHoliday->holiday_name = $holiday_name;
            $objHoliday->start = get_formatted_date($start_dt, 'Y-m-d');
            $objHoliday->end = get_formatted_date($end_dt, 'Y-m-d');
            $objHoliday->holiday_range = $start_dt . ' to '.$end_dt;
            $objHoliday->save();

            return response()->json(['status' => true, 'message' => 'Holiday added Successfully']);
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Something went wrong here '. $e->getMessage()]);
        }
    }

    /**
     * View the Holiday detail for edit Purpose
    */
    public function view($id)
    {
        try {
            $data = HolidayList::find($id);
            $split_dt = explode(' to ', $data->holiday_range);
            // pr($split_dt); die;
            $data->from = $split_dt[0];
            $data->to = $split_dt[1];
            return response()->json(['status' => true, 'data' => $data]);
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'msg' => 'Record Not Found '.$e->getMessage()]);
        }
        
    }

    /**
     * Update Holiday Detail
    */
    public function update(Request $request)
    {
        $id = $request->id;
        $holiday_name = $request->holiday_name;
        $st_dt = $request->st_dt;
        $ed_dt = $request->ed_dt;
        try {
            $data = HolidayList::find($id);
            $data->holiday_name = $holiday_name;
            $data->start = get_formatted_date($st_dt, 'Y-m-d');
            $data->end = get_formatted_date($ed_dt, 'Y-m-d');
            $data->holiday_range = $st_dt . ' to '.$ed_dt;
            $data->save();
            return response()->json(['status' => true, 'msg' => 'Holiday Range Updated Successfully']);
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'msg' => 'Holiday Detail could not update '.$e->getMessage()]);
        }
    }

    /**
     * Parmanent Delete the holiday from the listing 
    */
    public function delete(Request $request) 
    {
        try{
            HolidayList::destroy($request->id);
            return response()->json(['status' => true, 'message' => 'Holiday Deleted Successfully']);
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Holiday could not be deleted due to '.$e->getMessage()]);
        }
        
    }
}
