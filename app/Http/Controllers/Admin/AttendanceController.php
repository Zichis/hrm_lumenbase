<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        dd("Attendance index!");
    }
}
