<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SkinCareController extends Controller
{
    public function index()
    {
        return view('frontend.skincare.index');
    }
}
