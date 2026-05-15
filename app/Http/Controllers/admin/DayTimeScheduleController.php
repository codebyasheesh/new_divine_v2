<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DayTimeSchedule;
use Exception;
use Illuminate\Http\Request;

class DayTimeScheduleController extends Controller
{
    // Show the Day Time Schedule with Block Day times.
    public function index()
    {
        $data = DayTimeSchedule::all();
        return view('admin.schedule.index', compact('data'));
        // return view('admin.schedule.index');
    }

    public function add()
    {
        return view('admin.schedule.add');
    }

    public function edit($id)
    {
        $data = DayTimeSchedule::findOrFail($id);
        return view('admin.schedule.edit', compact('data'));
    }

    /**
     * This function check the available time slots. Exist or not
     */
    public function checkSchedule(Request $request)
    {
        try{
            $day = $request->dayval;
            // get Block times on day
            $data = DayTimeSchedule::where('day', $day)->first();

            $morningSlots = generateTimeSlots('09:30', '14:00');
            $no_slot_av = generateTimeSlots('14:30', '15:30');
            $eveningSlots = generateTimeSlots('16:00', '19:00');
            $allSlots = array_merge($morningSlots, $no_slot_av, $eveningSlots);

            $duration = 30;
            $slot_html = '';
            if(!empty($data->id)) {
                $times_arr = explode(',', $data->block_time);
                foreach($allSlots as $slot) {
                    if($slot == '02:30pm' || $slot == '03:00pm' || $slot == '03:30pm') {
                        $slot_html .= '<div class="col-md-4 col-sm-6 mt-3">
                            <div class="btn disable_times bg-white text-body text-uppercase p-2 w-100" data-value="'.$slot.'" data-duration="'.$duration.'">
                                '.$slot.'
                            </div>
                        </div>';
                    }
                    else {
                        if(in_array($slot, $times_arr)) {
                            $slot_html .= '<div class="col-md-4 col-sm-6 mt-3">
                            <div class="btn time_brd bg-white text-body text-uppercase p-2 w-100 time_highlight" data-value="'.$slot.'" data-duration="'.$duration.'">
                                '.$slot.'
                            </div>
                        </div>';
                        }
                        else {
                            $slot_html .= '<div class="col-md-4 col-sm-6 mt-3">
                                <div class="btn time_brd bg-white text-body text-uppercase p-2 w-100" data-value="'.$slot.'" data-duration="'.$duration.'">
                                    '.$slot.'
                                </div>
                            </div>';
                        }
                    }
                }

                return response()->json(['status' => true, 'message' => $slot_html]);
            }
            else {
                foreach($allSlots as $slot) {
                    if($slot == '02:30pm' || $slot == '03:00pm' || $slot == '03:30pm') {
                        $slot_html .= '<div class="col-md-4 col-sm-6 mt-3">
                            <div class="btn disable_times bg-white text-body text-uppercase p-2 w-100" data-value="'.$slot.'" data-duration="'.$duration.'">
                                '.$slot.'
                            </div>
                        </div>';
                    }
                    else {
                        $slot_html .= '<div class="col-md-4 col-sm-6 mt-3">
                            <div class="btn time_brd bg-white text-body text-uppercase p-2 w-100" data-value="'.$slot.'" data-duration="'.$duration.'">
                                '.$slot.'
                            </div>
                        </div>';
                    }
                }

                return response()->json(['status' => true, 'message' => $slot_html]);
            }
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Something went wrong '.$e->getMessage()]);
        }
    }

    /**
     * Save and update the time blocking update or insert
     */
    public function save(Request $request)
    {
        try{
            $day = $request->day;
            $times = '';
            if(!empty($request->block_time)) {
                $times = implode(",", $request->block_time);
            }
            
            $data = DayTimeSchedule::where('day', $day)->first();
            if(empty($data->id)) {
                // insert block times
                $daytimeobj = new DayTimeSchedule();
                $daytimeobj->day = $day;
                $daytimeobj->block_time = $times;
                $daytimeobj->save();
                return response()->json(['status' => true, 'message' => 'Day Time Blocked Successfully']);
            }
            else {
                // update block times for the day
                $data->day = $day;
                $data->block_time = $times;
                $data->save();
                return response()->json(['status' => true, 'message' => 'Day Time Blocked Updated Successfully']);
            }
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Something Wrong Here '.$e->getMessage()]);
        }
    }

    /**
     * Delete DayTime Schedule
     */
    public function deleteDayTime(Request $request)
    {
        try {
            $result = DayTimeSchedule::find($request->id);
            if($result) {
                $result->delete();
                return response()->json(['status' => true, 'message' => 'Block time Deleted Successfully']);
            }
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Something went wrong. '.$e->getMessage()]);
        }
    }
}
