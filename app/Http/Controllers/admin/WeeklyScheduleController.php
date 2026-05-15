<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\WeeklySchedule;
use Illuminate\Http\Request;

class WeeklyScheduleController extends Controller
{
    public function index()
    {
        $data = WeeklySchedule::all();
        return view('admin.schedule.weekly_schedule', compact('data'));
    }

    public function view(Request $request)
    {
        $data = WeeklySchedule::find($request->id);
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function update(Request $request)
    {
        $request->validate([
                'is_closed' => 'required',
                'start_time'=> 'required_if:is_closed,0',
                'end_time'  => 'required_if:is_closed,0',
                // Lunch Validation
                'lunch_start' => [
                    'nullable',
                    'required_with:lunch_end',
                    'after_or_equal:start_time', // Must be at or after start_time
                    'before:end_time'            // Must be before end_time
                ],
                'lunch_end'   => [
                    'nullable',
                    'required_with:lunch_start',
                    'after:lunch_start',         // Must be after lunch_start
                    'before_or_equal:end_time'   // Must be at or before end_time
                ],
            ],
            [
                'is_closed' => 'Please select day will closed or open',
                'start_time.required_if' => 'Start time is required',
                'end_time.required_if' => 'End time is required',
                'end_time.after' => 'End time must be after the start time.',
                
                'lunch_start.after_or_equal' => 'Lunch cannot start before the shift starts.',
                'lunch_start.before'         => 'Lunch must start before the shift ends.',
                'lunch_end.after'            => 'Lunch must end after it starts.',
                'lunch_end.before_or_equal'  => 'Lunch cannot end after the shift ends.',
            ]
        );

        $setting = getSetting();
        $clinic_start_tm = $setting->start_time;
        $clinic_end_tm = $setting->end_time;

        // Run custom validation only if open
        if($request->is_closed == 0) {
            if(strtotime($request->start_time) < strtotime($clinic_start_tm)){
                return response()->json([
                    'status' => 422,
                    'message' => 'Start time cannot be earlier than clinic opening time ('.$clinic_start_tm.')'
                ]);
            }

            if(strtotime($request->end_time) > strtotime($clinic_end_tm)) {
                return response()->json([
                    'status' => 422,
                    'message' => 'End time cannot be later than clinic closing time ('.$clinic_end_tm.')'
                ]);
            }
            if(strtotime($request->start_time) >= strtotime($request->end_time)) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Start time must be less than end time'
                ]);
            }
            
        }

        $schedule = WeeklySchedule::findOrFail($request->id);
        $getday = getDayName($schedule->day_of_week);
        $schedule->is_closed = $request->is_closed;
        if(!empty($request->start_time)) {
            $schedule->start_time = $request->start_time;
        }
        if(!empty($request->end_time)) {
            $schedule->end_time = $request->end_time;
        }
        if(!empty($request->lunch_start)) {
            $schedule->lunch_start = $request->lunch_start;
        }
        if(!empty($request->lunch_end)) {
            $schedule->lunch_end = $request->lunch_end;
        }
        if($request->is_closed == 1){
            $schedule->start_time = null;
            $schedule->end_time = null;
            $schedule->lunch_start = null;
            $schedule->lunch_end = null;
        }
        $schedule->save();
        return response()->json(['status' => 202, 'message' => $getday.' Schedule updated Successfully']);
    }
}

