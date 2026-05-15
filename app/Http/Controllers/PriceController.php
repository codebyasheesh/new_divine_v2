<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index()
    {
        $parent_services = [1,42,2,4]; // All 4 Parent Service Id Sequence
        $services = Service::whereIn('id', $parent_services)
        ->where('status', 1)
        ->with(['children' => function ($q) {
            $q->where('status', 1)
            ->orderBy('price');
        }])
        ->orderByRaw(
            "FIELD(id, " . implode(',', $parent_services) . ")"
        )
        ->get();

        return view('frontend.price.index', compact('services'));
    }
}
