<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\HolidayList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        // get Confirmed Booking count
        $confirmed_bookings = Booking::where('booking_status', 'confirmed')->count();
        
        // Get Pending Booking count
        $pending_bookings = Booking::where('booking_status', 'pending')->count();

        // Get Completed Booking Count
        $completed_bookings = Booking::where('booking_status', 'completed')->count();

        // Get Canceled Booking Count
        $canceled_bookings = Booking::where('booking_status', 'canceled')->count();

        // Get Declined Booking Count
        $declined_bookings = Booking::where('booking_status', 'declined')->count();

        // Wait Bookings
        // $wait_bookings = WaitlistBooking::where('status', 'pending')->count();

        // Registered Users Count
        $users_count = User::where('role', 'customer')->count();
        $data = array(
            'confirm_b_count' => $confirmed_bookings,
            'complete_b_count' => $completed_bookings,
            'cancel_b_count' => $canceled_bookings,
            'pending_b_count' => $pending_bookings,
            'declined_b_count' => $declined_bookings,
            'customer_count' => $users_count
        );
        return view('admin.dashboard.index', compact('data'));
    }

    public function events(Request $request)
    {
        $start = $request->get('start'); // FullCalendar will send visible start date
        $end   = $request->get('end');  // FullCalendar will send visible end date
        
        $st = get_formatted_date($start, 'Y-m-d');
        $ed = get_formatted_date($end, 'Y-m-d');
        $bookings = Booking::where('booking_date', '>=', $st)->where('booking_date', '<=', $ed)->get();

        $bookingEvents = $bookings->map(function ($booking) {
        // extract start time
            $startTime = null;
            $formattedTime = '';
            if (!empty($booking->time_slots)) {
                $timeParts = explode(',', $booking->time_slots);
                $time = trim($timeParts[0]); // take start time
                $startTime = date('H:i:s', strtotime($booking->booking_date.' '.$time));
                $formattedTime = date('h:i A', strtotime($booking->booking_date.' '.$time)); // e.g. 10:00 AM
            }

            return [
                'id'    => "B-" . $booking->id,
                // 🔹 Multi-line: Customer Name, Time, Status
                'title' => ucwords($booking->customer_name) 
                        . ($formattedTime ? "\n" . $formattedTime : '') 
                        . ", " . ucfirst($booking->booking_status),
                'start' => $booking->booking_date . ($startTime ? 'T' . $startTime : ''),
                'backgroundColor' => $this->getStatusColor($booking->booking_status),
                'borderColor'     => $this->getStatusColor($booking->booking_status),
                'textColor'       => '#fff',
                'url'   => route('admin.appointments', ['status' => $booking->booking_status]),
            ];
        });

        // Fetch Holidays
        $holidays = HolidayList::where(function ($q) use ($st, $ed) {
            $q->whereBetween('start', [$st, $ed])
            ->orWhereBetween('end', [$st, $ed]);
        })->get();

        $holidayEvents = $holidays->map(function ($holiday) {
            return [
                'id'    => "H-" . $holiday->id,
                'title' => 'Holiday: ' . $holiday->holiday_name,
                'start' => $holiday->start,
                'end'   => $holiday->end ? date('Y-m-d', strtotime($holiday->end . ' +1 day')) : null, 
                
                'backgroundColor' => '#ff4d4d', // red shade
                'borderColor'     => '#ff0000',
                'textColor'       => '#FFF',
            ];
        });

        // Merge Both Events and Holidays
        if($bookingEvents->isEmpty()) {
            $events = $holidayEvents;
        }
        else {
            $events = $bookingEvents->merge($holidayEvents);
        }
        
        return response()->json($events);
    }

    private function getStatusColor($status)
    {
        return match (strtolower($status)) {
            'confirmed' => '#007bff', // blue
            'completed' => '#28a745', // green
            'canceled'  => '#dc3545', // red
            'pending'   => '#ffc107', // yellow
            'declined'  => '#6c757d', // gray
            'default'   => '#0dcaf0',
        };
    }
}
