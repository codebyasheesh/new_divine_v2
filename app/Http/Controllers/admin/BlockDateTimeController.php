<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BlockDate;
use App\Models\HolidayList;
use DateInterval;
use DatePeriod;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BlockDateTimeController extends Controller
{
    public function index()
    {
        return view('admin.schedule.dateblock');
    }

    /**
     * Show block Dates in Calendar View.
     */
    public function calendarDates(Request $request)
    {
        // 17 working slots per day
        $workingSlots = [
            '09:30am','10:00am','10:30am','11:00am','11:30am',
            '12:00pm','12:30pm','01:00pm','01:30pm',
            // Missing slots intentionally not included
            '04:00pm','04:30pm','05:00pm','05:30pm',
            '06:00pm','06:30pm','07:00pm',
        ];

        $totalSlots = count($workingSlots);

        /**
         * -------------------------------------------------------------
         * FETCH SLOTS BLOCKED FROM block_dates TABLE
         * -------------------------------------------------------------
         */
        $results = BlockDate::all();

        $calendarData = [];

        foreach ($results as $slot) {
            $blockedDates = !empty($slot->block_date)
                            ? explode(",", $slot->block_date)
                            : [];

            foreach ($blockedDates as $date) {
                $date = trim($date);

                if (!isset($calendarData[$date])) {
                    $calendarData[$date] = [
                        'blocked_slots' => [],
                        'day_type'      => null
                    ];
                }

                $calendarData[$date]['blocked_slots'][] = $slot->time_slot;
            }
        }


        /**
         * -------------------------------------------------------------
         * FETCH HOLIDAYS FROM holiday_lists TABLE
         *    and mark ALL 17 SLOTS as BLOCKED in each holiday date
         * -------------------------------------------------------------
         */
        $holidays = HolidayList::all();

        foreach ($holidays as $holiday) {

            $start = strtotime($holiday->start);
            $end   = strtotime($holiday->end);

            // Loop from start to end date
            for ($date = $start; $date <= $end; $date = strtotime("+1 day", $date)) {

                $dateStr = date('Y-m-d', $date);

                if (!isset($calendarData[$dateStr])) {
                    $calendarData[$dateStr] = [
                        'blocked_slots' => [],
                        'day_type'      => $holiday->holiday_name
                    ];
                }

                // block ALL working slots
                $calendarData[$dateStr]['blocked_slots'] = $workingSlots;

                // set holiday name as type
                $calendarData[$dateStr]['day_type'] = $holiday->holiday_name;
            }
        }

        /**
         * -------------------------------------------------------------
         * 3️⃣ BUILD EVENTS FOR FULLCALENDAR
         * -------------------------------------------------------------
         */
        $events = [];

        foreach ($calendarData as $date => $data) {

            $blockedSlots = array_unique(
                array_intersect($workingSlots, $data['blocked_slots'])
            );

            $openSlots = array_diff($workingSlots, $blockedSlots);

            $blockedCount = count($blockedSlots);
            $openCount    = count($openSlots);

            // Determine status label + color
            if ($blockedCount == 0) {
                $status = "All slots are available";
                $color  = "#229954";
            }
            elseif ($blockedCount == $totalSlots) {
                $status = !empty($data['day_type'])
                            ? $data['day_type'] . " (Full Day Block)"
                            : "Full Day Block";
                $color  = "#C0392B";
            }
            else {
                $status = "Partial Day Block";
                $color  = "#F39C12";
            }

            $isBlockedDate = ($blockedCount > 0);
            $events[] = [
                'title' => $status,
                'start' => $date,
                'allDay'=> true,
                'color' => $color,
                'extendedProps' => [
                    'total_slots'   => $totalSlots,
                    'blocked_slots' => array_values($blockedSlots),
                    'open_slots'    => array_values($openSlots),
                    'day_type'      => $data['day_type'],
                    'is_holiday'    => (!empty($data['day_type'])),
                    'is_blocked_date' => $isBlockedDate
                ]
            ];
        }
        return response()->json($events);
    }
    
    public function addBlockDateTime()
    {
        return view('admin.schedule.add_block_date_time');
    }

    /**
     * Update Block Date on time Slot
    */
    public function saveBlockDate(Request $request)
    {
        $request->validate([
            'dt' => 'required'
        ]);

        try{
            $dt = date('Y-m-d', strtotime($request->dt));
            $time_slots = $request->block_time;
            $day_name = getDayName(date('N', strtotime($dt)));
            $add_dat = '';
            foreach($time_slots as $val) {
                $getResult = BlockDate::where('time_slot', $val)->where('day', $day_name)->first(['block_date']);
                $block_dates = explode(',', $getResult->block_date);
                if(!empty($getResult->block_date) && !in_array($dt, $block_dates)) {
                    $add_dat = $getResult->block_date.','.$dt;
                }
                elseif(!empty($getResult->block_date) && in_array($dt, $block_dates)) {
                    continue;
                }
                else {
                    $add_dat = $dt;
                }
                BlockDate::where('time_slot', $val)->where('day', $day_name)->update(['block_date' => $add_dat]);
            }
            return response()->json(['status' => true, 'message' => 'Time block on Date Successfully']);
        }
        catch(Exception $e){
            return response()->json(['status' => false, 'message' => 'Time could not be blocked on Date due to '.$e->getMessage()]);
        }
    }

    /**
     * Check the Block Time on Date
     */
    public function getBlockDateAndTime(Request $request)
    {
        $dt = date('Y-m-d', strtotime($request->dt)); // Date
        $day_name = getDayName(date('N', strtotime($dt)));

        // Get Day Name records from Block Dates Table
        $data = BlockDate::where('day', $day_name)->get();

        // Get slot ids from booking table on date which is selected.

        $morningSlots = generateTimeSlots('09:30', '01:30');
        $no_slot_av = generateTimeSlots('14:00', '15:30');
        $eveningSlots = generateTimeSlots('16:00', '19:00');
        $allSlots = array_merge($morningSlots, $no_slot_av, $eveningSlots);
        $final_arr = [];
        $slot_html = '';
        if($data->isNotEmpty()) {
            $i = 0;
            // pr($data->toArray());die;
            foreach($data as $val) {
                $block_dates = [];
                if(!empty($val->block_date)) {
                    $block_dates = explode(",", $val->block_date);
                }

                if(empty($val->block_date)) {
                    $final_arr[$i]['id'] = $val->id;
                    $final_arr[$i]['time_slot'] = $val->time_slot;
                    $final_arr[$i]['av'] = '1';
                }
                elseif(!empty($val->block_date) && !in_array($dt, $block_dates)) {
                    $final_arr[$i]['id'] = $val->id;
                    $final_arr[$i]['time_slot'] = $val->time_slot;
                    $final_arr[$i]['av'] = '1';
                }
                elseif(!empty($val->block_date) && in_array($dt, $block_dates)) {
                    $final_arr[$i]['id'] = $val->id;
                    $final_arr[$i]['time_slot'] = $val->time_slot;
                    $final_arr[$i]['av'] = '0';
                }
                
                $i++;
            }
            // pr($final_arr); die;
            
            $duration = 30;
            /*foreach($allSlots as $slot) {
                if($slot == '02:00pm' || $slot == '02:30pm' || $slot == '03:00pm' || $slot == '03:30pm') {
                    $slot_html .= '<div class="col-md-4 col-sm-6 mt-3">
                        <div class="btn disable_times bg-white text-body text-uppercase p-2 w-100" data-value="'.$slot.'" data-duration="'.$duration.'">
                            '.$slot.'
                        </div>
                    </div>';
                }
            }*/

            $default_block_time = ['02:00pm','02:30pm','03:00pm','03:30pm'];

            foreach($final_arr as $val) {
                if($val['av'] == '1' && !in_array($val['time_slot'], $default_block_time)) {
                    $slot = $val['time_slot'];
                    $slot_html .= '<div class="col-md-4 col-sm-6 mt-3">
                        <div class="btn time_brd bg-white text-body text-uppercase p-2 w-100" data-value="'.$slot.'" data-duration="'.$duration.'">
                            '.$slot.'
                        </div>
                    </div>';
                }
                elseif($val['av'] == '0' && !in_array($val['time_slot'], $default_block_time)) {
                    $slot = $val['time_slot'];
                    $slot_html .= '<div class="col-md-4 col-sm-6 mt-3">
                        <div class="btn time_brd engaged bg-white text-body text-uppercase p-2 w-100 time_highlight" data-value="'.$slot.'" data-duration="'.$duration.'">
                            '.$slot.'
                        </div>
                    </div>';
                }
                else {
                    foreach($default_block_time as $def_val) {
                        $slot_html .= '<div class="col-md-4 col-sm-6 mt-3">
                            <div class="btn disable_times bg-white text-body text-uppercase p-2 w-100" data-value="'.$def_val.'" data-duration="'.$duration.'">
                                '.$def_val.'
                            </div>
                        </div>';
                    }
                }
            }

            return response()->json(['status' => true, 'message' => $slot_html]);
        }
    }

    public function getBlockDatesById(Request $request)
    {
        try {
            $id = $request->id;
            $data = BlockDate::findOrFail($id);
            if(!empty($data->block_date)) {
                $dt_ar = explode(",", $data->block_date);
                $date_checkboxs = '';
                $i = 1;
                foreach($dt_ar as $val) {
                    $date_checkboxs .= '<div class="form-check">
                                    <input class="form-check-input datschk" type="checkbox" name="b_dat[]" id="b_dat_'.$i.'" value="'.$val.'">
                                    <label class="form-check-label" for="b_dat_'.$i.'">
                                        '.get_formatted_date($val, 'M d, Y').'
                                    </label>
                                </div>';
                    $i++;
                }
                return response()->json(['status' => true, 'message' => $date_checkboxs]);
            }
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Record could not be found due to '.$e->getMessage()]);
        }
    }

    public function unBlockDatesOfTime(Request $request)
    {
        try {
            $day_name = getDayName(date('N', strtotime($request->date)));
            $slots = $request->slots;
            $dts[] = $request->date;
            foreach($slots as $slot) {
                $data = BlockDate::where('day', $day_name)->where('time_slot', $slot)->first();
                if(!empty($data->block_date)) {
                    $exists_dats = explode(",", $data->block_date);
                    // pr($exists_dats);die;
                    $remain_dats = array_diff($exists_dats, $dts);

                    if(empty($remain_dats)) {
                        BlockDate::where('id', $data->id)->update(['block_date' => '']);
                    }
                    if(!empty($remain_dats)) {
                        $commsepp = implode(",", $remain_dats);
                        BlockDate::where('id', $data->id)->update(['block_date' => $commsepp]);
                    }
                    
                }
            }
            return response()->json(['status' => true, 'message' => 'Selected Dates are unblocked Successfully']);
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Selected Date could not be unblock due to '.$e->getMessage()]);
        }
    }

    public function addHoliday()
    {
        return view('admin.schedule.add_holiday');
    }

    public function saveHoliday(Request $request)
    {
        $request->validate([
            'holiday_name' => 'required'
        ]);
        
        try{
            $start_dt = $request->st_dt;
            $end_dt = $request->ed_dt;
            $holiday_name = $request->holiday_name;
            // $dt = date('Y-m-d', strtotime($request->dt));

            // get count number of days of Holiday
            $diff = strtotime($end_dt) - strtotime($start_dt);
            $days = floor($diff/(60*60*24)) + 1; 
            

            $blk_dates = [];
            $day_name = [];
            for ($i = 0; $i < $days; $i++) {
                $blk_dates[] = date('Y-m-d', strtotime($start_dt . " +{$i} day"));
                $dat = date('Y-m-d', strtotime($start_dt . " +{$i} day"));
                $day_name[] = getDayName(date('N', strtotime($dat)));
            }

            $dtt = implode(',', $blk_dates);
            // For each date check any date already ingage in normal block Date. if already blocked then convert it into Holiday date.
            foreach($day_name as $daynm) {
                $times = BlockDate::where('day', $daynm)->get();
                foreach($times as $tm) {
                    if(!empty($tm->block_date)) {
                        $block_dts = explode(",", $tm->block_date);
                        $reqarr = array_diff($blk_dates, $block_dts);
                        if(!empty($block_dts) && !empty($reqarr)) {
                            // Date will not update
                            $updt_blk_dt = $tm->block_date.','.implode(',', $reqarr);
                            BlockDate::where('id', $tm->id)->update(['block_date' => $updt_blk_dt, 'date_type' => $holiday_name, 'holiday_range' => $start_dt.' to '.$end_dt]);
                        }
                        elseif(empty($block_dts)) {
                            BlockDate::where('id', $tm->id)->update(['block_date' => $dtt, 'date_type' => $holiday_name, 'holiday_range' => $start_dt.' to '.$end_dt]);
                        }
                    }
                    else {
                        BlockDate::where('id', $tm->id)->update(['block_date' => $dtt, 'date_type' => $holiday_name, 'holiday_range' => $start_dt.' to '.$end_dt]);
                    }
                }
            }
            return response()->json(['status' => true, 'message' => 'Holiday added Successfully']);
        }
        catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Something went wrong here '. $e->getMessage()]);
        }
    }

    private function getDayColor($day)
    {
        $assign_color = [
            'Monday' => '#2E86C1',
            'Tuesday' => '#C0392B',
            'Wednesday' => '#229954',
            'Thursday' => '#D35400',
            'Friday' => '#F1C40F',
            'Saturday' => '#8E44AD',
            'Sunday' => '#E67E22'
        ];

        return $assign_color[$day] ?? '#000000';
    }

}
