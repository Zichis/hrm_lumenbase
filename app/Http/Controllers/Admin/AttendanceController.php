<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Attendance;
use App\Http\Controllers\Controller;
use App\Repository\UserRepository;

class AttendanceController extends Controller
{
    private $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $attendances = Attendance::all();

        return response()->json($attendances);
    }

    public function clockIn()
    {
        //
    }
}
