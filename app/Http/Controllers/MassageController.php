<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MassageController extends Controller
{
    public function index()
    {
        return view('frontend.massage_therapy.index');
    }
}
