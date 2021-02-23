<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Attendance;
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
        $attendances = Attendance::all();

        return response()->json($attendances);
    }

    public function clockIn()
    {
        /*$user = User::find(1);
        $attendance = Attendance::create([
            'date' => new \DateTime(),
            'clock_in' => new \DateTime()
        ]);
        $user->attendance()->attach($attendance->id);

        return response()->json(['message' => 'User clocked in']);*/
    }
}
