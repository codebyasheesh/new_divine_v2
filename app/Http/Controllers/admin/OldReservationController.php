<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TblReservation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OldReservationController extends Controller
{
    public function index()
    {
        return view('admin.oldreservation.index');
    }

    public function list(Request $request)
    {
        if($request->ajax()) {
            $data = TblReservation::with('TblTimeSlot')
                ->orderByDesc('appointment_date');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('customer_name', function($row) {
                    $name = $row->full_name ?? '-';
                    $email = $row->email ?? '-';
                    $mobile = $row->mobile ?? '-';
                    $customerDetail = '<div><div>' . $name . '</div><div>' . $email . '</div><div>' . $mobile . '</div></div>';
                    return $customerDetail;
                })
                ->addColumn('time_date', function($row) {
                    $dt = get_formatted_date($row->appointment_date, 'M d, Y');
                    $tm = $row->TblTimeSlot->slot ?? '-';
                    $date_time = '<div>
                        <div>' . $tm . '</div>
                        <div>' . $dt . '</div>
                    </div>';
                    return $date_time;
                })
                ->addColumn('services', function($row) {
                    return $row->services ?? '-';
                })

                ->addColumn('status', function($row) {
                    $status = strtolower($row->status);
                    $badges = [
                        'confirmed' => 'success',
                        'canceled'  => 'danger',
                        'pending'   => 'warning',
                    ];
                    $color = $badges[$status] ?? 'secondary';
                    return '<div><span class="badge text-bg-' . $color . '">' . ucfirst($status) . '</span></div>';
                })
                ->addColumn('action', function($row){
                    $viewDetail = "viewBookingDetail('".$row->id."')";
                    return '<button class="btn btn-sm btn-primary" onclick="'.$viewDetail.'">View</button>';
                })
                ->filterColumn('customer_name', function($query, $keyword) {
                    $query->whereHas('oldcustomer', function($q) use ($keyword) {
                        $q->where('full_name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('services', function ($query, $keyword) {
                    $query->where('services', 'like', "%{$keyword}%"); // Change this if it's relational
                })
                ->filterColumn('status', function ($query, $keyword) {
                    $query->where('status', 'like', "%{$keyword}%"); // Change this if it's relational
                })
                ->rawColumns(['customer_name', 'time_date', 'services', 'status', 'action'])
            ->make(true);
        }
    }
}
