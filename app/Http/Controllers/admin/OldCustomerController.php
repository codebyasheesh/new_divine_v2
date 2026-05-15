<?php

namespace App\Http\Controllers\admin;

use App\Models\OldCustomer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OldCustomerController extends Controller
{
    public function index()
    {
        return view('admin.oldcustomerdata.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $oldCustomers = OldCustomer::orderByDesc('created_at');
            return DataTables::of($oldCustomers)
                ->addIndexColumn()
                ->addColumn('name', function ($oldCustomer) {
                    return $oldCustomer->full_name ?? '-';
                })
                ->addColumn('email', function ($oldCustomer) {
                    return $oldCustomer->email ?? '-';
                })
                ->addColumn('mobile', function ($oldCustomer) {
                    return $oldCustomer->mobile ?? '-';
                })
                ->addColumn('action', function ($oldCustomer) {
                    $viewDetail = "viewOldCustomerDetail('" . $oldCustomer->id . "')";
                    $action = '<div class="d-flex justify-content-center">';
                    $action .= '<button class="btn btn-sm btn-primary me-1" onclick="' . $viewDetail . '"><i class="bi bi-pencil-square"></i></button>';
                    $action .= '</div>';
                    return $action;
                })
                ->rawColumns(['name', 'email', 'mobile', 'action'])
                ->make(true);
        }
    }
}
