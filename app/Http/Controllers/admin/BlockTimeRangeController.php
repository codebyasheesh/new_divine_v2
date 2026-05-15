<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BlockTimeRange;
use App\Models\WeeklySchedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class BlockTimeRangeController extends Controller
{
    public function index()
    {
        return view('admin.schedule.block_time_range');
    }

    public function list(Request $request)
    {
        if($request->ajax()) {
            $query = BlockTimeRange::select();
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('dayname', function ($row){
                if(!empty($row->day_of_week)) {
                    $daynm = getDayName($row->day_of_week);
                    return $daynm;
                }
                else {
                    return 'N/A';
                }
                    
            })
            ->addColumn('start_date', function($row) {
                if(!empty($row->start_date)) {
                    return get_formatted_date($row->start_date, 'M d, Y');
                }
                else {
                    return 'N/A';
                }
            })
            ->addColumn('end_date', function($row) {
                if(!empty($row->end_date)) {
                    return get_formatted_date($row->end_date, 'M d, Y');
                }
                else {
                    return 'N/A';
                }
            })
            ->addColumn('start_time', function($row) {
                if(!empty($row->start_time)) {
                    return get_formatted_date($row->start_time, 'h:i A');
                }
                else {
                    return 'N/A';
                }
            })
            ->addColumn('end_time', function($row) {
                if(!empty($row->end_time)) {
                    return get_formatted_date($row->end_time, 'h:i A');
                }
                else {
                    return 'N/A';
                }
            })
            ->addColumn('is_closed', function($row) {
                if($row->is_full_day == 1) {
                    return '<div><span class="badge text-bg-danger">Yes</span></div>';
                }
                else {
                    return '<div><span class="badge text-bg-warning">No</span></div>';
                }
            })
            ->addColumn('action', function($row){
                // $delete_client = "deleteClient('".$row->id."')";
                $delete_blocktm = "deleteBlockTime('".$row->id."')";
                
                return '<div class="d-flex align-items-center">
                    <a href="javascript:void(0);" onclick="'.$delete_blocktm.'" class="btn btn-sm btn-danger" data-bs-toggletip="tooltip" data-bs-title="Delete Blocking"><i class="bi bi-trash"></i> Delete</a>
                </div>';
            })
            ->rawColumns(['is_closed', 'action'])
            ->make(true);
        }
    }

    public function add(Request $request)
    {
        // pr($request->toArray());die;
        // Step 1: Validation
        $validated = $request->validate([
            'type' => ['required', Rule::in(['weekly', 'date', 'range'])],
            // Conditional fields
            'day_of_week' => [
                'nullable',
                'integer',
                'min:1',
                'max:7',
                Rule::requiredIf(fn () => $request->type === 'weekly')
            ],

            'start_date' => [
                'nullable',
                'date',
                Rule::requiredIf(fn () => in_array($request->type, ['date', 'range']))
            ],

            'end_date' => [
                'nullable',
                'date',
                Rule::requiredIf(fn () => in_array($request->type, ['date', 'range']))
            ],

            'is_full_day' => ['required', 'boolean'],

            // Time validation
            'start_time' => [
                'nullable',
                'date_format:H:i',
                Rule::requiredIf(fn () => !$request->is_full_day)
            ],

            'end_time' => [
                'nullable',
                'date_format:H:i',
                'after:start_time',
                Rule::requiredIf(fn () => !$request->is_full_day)
            ],

            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->type === 'date') {
            if ($request->start_date !== $request->end_date) {
                return response()->json([
                    'message' => 'For type=date, start_date and end_date must be same.'
                ], 422);
            }
        }

        if ($request->type === 'range') {
            if(strtotime($request->end_date) < strtotime($request->start_date)) {
                return response()->json([
                    'message' => 'end_date must be greater than or equal to start_date.'
                ], 422);
            }
        }
        if ($request->is_full_day) {
            $validated['start_time'] = null;
            $validated['end_time']   = null;
        }

        // If partial → ensure both exist
        if (!$request->is_full_day) {
            if (!$request->start_time || !$request->end_time) {
                return response()->json([
                    'message' => 'Start time and end time are required for partial block.'
                ], 422);
            }
        }
        $objBlockTm = new BlockTimeRange();
        $objBlockTm->type = $request->type;
        $objBlockTm->day_of_week = $request->day_of_week;
        $objBlockTm->is_full_day = $request->is_full_day;
        if(!empty($request->start_date)) {
            $objBlockTm->start_date = date('Y-m-d', strtotime($request->start_date));
        }
        if(!empty($request->end_date)) {
            $objBlockTm->end_date = date('Y-m-d', strtotime($request->end_date));
        }
        if(!empty($request->start_time)) {
            $objBlockTm->start_time = date('H:i:s', strtotime($request->start_time));
        }
        if(!empty($request->end_time)) {
            $objBlockTm->end_time = date('H:i:s', strtotime($request->end_time));
        }
        
        $objBlockTm->save();


        // $block = BlockTimeRange::create($validated);
        return response()->json([
            'status' => true,
            'message' => 'Blocked time created successfully.',
        ]);
    }

    public function delete(Request $request)
    {
        $data = BlockTimeRange::where('id', $request->id)->first();
        if($data) {
            $data->delete();
            return response()->json(['status' => true, 'message' => 'Block time record delete successfully']);
        }
        else {
            return response()->json(['status' => true, 'message' => 'Record not found']);
        }
    }

    public function blockSchedules() 
    {
        return view('admin.schedule.schedule_calendar');
    }

    public function scheduleFullCalendar(Request $request)
    {
        $setting = getSetting();

        $default_clinic_start = $setting->start_time;
        $default_clinic_end = $setting->end_time;
        // clinic default open time slots
        $baseSlots = generateTimeSlots(date('H:i', strtotime($default_clinic_start)), date('H:i', strtotime($default_clinic_end)), $setting->duration);
       
        // Convert to pairs of [start, end] in H:i format
        $timeSlots = [];
        for ($i = 0; $i < count($baseSlots) - 1; $i++) {
            $start = date('H:i', strtotime($baseSlots[$i]));
            $end = date('H:i', strtotime($baseSlots[$i + 1]));
            $timeSlots[] = [$start, $end];
        }

       /**
         * -------------------------------------------------------------
         * 3️⃣ BUILD EVENTS FOR FULLCALENDAR
         * -------------------------------------------------------------
         */
        $events = [];

        $start = $request->start; // Y-m-d
        $end = $request->end; // Y-m-d

        if (!$start || !$end) {
            return response()->json($events);
        }

        // Get all blocks and weekly schedule data
        $blocks = BlockTimeRange::all();
        $weeklySchedules = WeeklySchedule::all()->keyBy('day_of_week');

        $current = strtotime($start);
        $endTime = strtotime($end);

        while ($current <= $endTime) {
            $date = date('Y-m-d', $current);
            $dayOfWeek = date('N', $current); // 1=Monday, 7=Sunday

            $blockedSlots = [];
            $isFullDayBlocked = false;

            $weeklySchedule = $weeklySchedules->get($dayOfWeek);
            $lunchRange = null;
            $isWeekClosed = false;

            if ($weeklySchedule) {
                if (!empty($weeklySchedule->lunch_start) && !empty($weeklySchedule->lunch_end)) {
                    $lunchRange = [
                        date('H:i', strtotime($weeklySchedule->lunch_start)),
                        date('H:i', strtotime($weeklySchedule->lunch_end))
                    ];
                }
                $isWeekClosed = (int) $weeklySchedule->is_closed === 1;
            }

            if ($isWeekClosed) {
                $events[] = [
                    'title' => 'Clinic Closed',
                    'start' => $date,
                    'allDay' => true,
                    'backgroundColor' => '#dc3545',
                    'borderColor' => '#dc3545',
                    'className' => 'blocked-full'
                ];
                $current = strtotime('+1 day', $current);
                continue;
            }

            foreach ($blocks as $block) {
                $isBlocked = false;
                if ($block->type == 'weekly' && $block->day_of_week == $dayOfWeek) {
                    $isBlocked = true;
                } elseif ($block->type == 'date' && $block->start_date == $date) {
                    $isBlocked = true;
                } elseif ($block->type == 'range' && $block->start_date <= $date && $block->end_date >= $date) {
                    $isBlocked = true;
                }

                if ($isBlocked) {
                    if ($block->is_full_day) {
                        // Full day block
                        $events[] = [
                            'title' => 'Full Day Block',
                            'start' => $date,
                            'allDay' => true,
                            'backgroundColor' => '#dc3545', // red
                            'borderColor' => '#dc3545',
                            'className' => 'blocked-full'
                        ];
                        $isFullDayBlocked = true;
                        break; // No need to check more for this day
                    } else {
                        // Partial block: find overlapping 30-min slots
                        $blockStart = strtotime($block->start_time);
                        $blockEnd = strtotime($block->end_time);
                        foreach ($timeSlots as $slot) {
                            $slotStart = strtotime($slot[0]);
                            $slotEnd = strtotime($slot[1]);
                            if (max($slotStart, $blockStart) < min($slotEnd, $blockEnd)) {
                                $blockedSlots[] = $slot;
                            }
                        }
                    }
                }
            }

            if (!$isFullDayBlocked) {
                // Add events for blocked 30-min slots
                foreach (array_unique($blockedSlots, SORT_REGULAR) as $slot) {
                    $is_lunch = $this->isLunchSlot($slot, $lunchRange);
                    $events[] = [
                        'title' => 'Unavailable',
                        'start' => $date . 'T' . $slot[0] . ':00',
                        'end' => $date . 'T' . $slot[1] . ':00',
                        'backgroundColor' => '#fd7e14', // orange
                        'borderColor' => '#fd7e14',
                        'className' => 'blocked-partial',
                        'extendedProps' => ['is_lunch' => $is_lunch]
                    ];
                }

                // Available 30-min slots
                $availableSlots = array_filter($timeSlots, function ($slot) use ($blockedSlots) {
                    return !in_array($slot, $blockedSlots);
                });

                foreach ($availableSlots as $slot) {
                    $is_lunch = $this->isLunchSlot($slot, $lunchRange);
                    $events[] = [
                        'title' => $is_lunch ? 'Lunch Time' : 'Available',
                        'start' => $date . 'T' . $slot[0] . ':00',
                        'end' => $date . 'T' . $slot[1] . ':00',
                        'backgroundColor' => $is_lunch ? '#ffc107' : '#FFFFFF', // yellow for lunch, green for available
                        'borderColor' => $is_lunch ? '#ffc107' : '#FFFFFF',
                        'className' => $is_lunch ? 'lunch' : 'available',
                        'extendedProps' => ['is_lunch' => $is_lunch]
                    ];
                }
            }

            $current = strtotime('+1 day', $current);
        }

        return response()->json($events);
    }

    private function isLunchSlot($slot, $lunchRange = null)
    {
        if (!$lunchRange || count($lunchRange) !== 2) {
            return false;
        }

        $slotStart = strtotime($slot[0]);
        $slotEnd = strtotime($slot[1]);
        $lunchStart = strtotime($lunchRange[0]);
        $lunchEnd = strtotime($lunchRange[1]);

        return max($slotStart, $lunchStart) < min($slotEnd, $lunchEnd);
    }
}
