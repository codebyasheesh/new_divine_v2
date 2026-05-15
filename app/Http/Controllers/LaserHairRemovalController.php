<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaserHairRemovalController extends Controller
{
    public function index()
    {
        return view('frontend.laser_hair_removal.index');
    }
}
