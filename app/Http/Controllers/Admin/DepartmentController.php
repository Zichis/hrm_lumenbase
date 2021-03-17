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

    public function update(Request $request, $id)
    {
        $filteredRequest = array_filter($request->all());

        $user = Department::find($id)->update($filteredRequest);

        $code = 200;
        $output = [
            'code' => $code,
            'message' => 'Department updated!',
        ];

        return response()->json($output, $code);
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->forceDelete();

        $code = 200;
        $output = [
            'message' => 'Department deleted!',
        ];

        return response()->json($output, $code);
    }
}
