<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with(['users'])->get();

        return response()->json($departments);
    }

    public function create(Request $request)
    {
        $validated = $this->validate(
            $request, [
                'name' => 'required|unique:departments',
            ]
        );

        $department = Department::create([
            'name' => $request->name,
        ]);

        $code = 200;
        $output = [
            'msg' => 'Department created!',
        ];

        return response()->json($output, $code);
    }

    public function show($id)
    {
        $department = Department::with('users.personal')->where('id',$id)->first();
        $data = ["department" => $department];

        return response()->json($data, 200);
    }
}
