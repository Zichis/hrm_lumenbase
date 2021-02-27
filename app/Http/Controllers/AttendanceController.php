<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index()
    {
        //
    }

    public function clockIn()
    {
        $today = new \DateTime();
        $currentDate = $today->format('Y-m-d');
        $attendance = Auth::user()->attendance()->where('date', $currentDate)->get();

        if ($attendance->count() > 0) {
            return response()->json(['msg' => 'User clocked in already!'], 403);
        }

        if ($today->format('H') < 8 || $today->format('H') > 16) {
            return response()->json(['msg' => 'You cannot clock in before/after working hours.'], 403);
         }

        $attendance = Attendance::create([
            'date' => new \DateTime(),
            'clock_in' => new \DateTime()
        ]);
        Auth::user()->attendance()->attach($attendance->id);

        return response()->json(['msg' => 'Success', 'attendances' => Auth::user()->attendance]);
    }

    public function status()
    {
        $today = new \DateTime();
        $currentDate = $today->format('Y-m-d');
        $attendance = Auth::user()->attendance()->where('date', $currentDate)->get();
        $canClockIn = false;
        $canClockOut = false;

        if ($attendance->count() == 0 && $today->format('H') >= 8 && $today->format('H') <= 15) {
            $canClockIn = true;
        }

        return response()->json(['msg' => 'Success', 'canClockIn' => $canClockIn]);
    }
}
