<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MicroneedlingController extends Controller
{
    public function index()
    {
        return view('frontend.microneedling.index');
    }
}
