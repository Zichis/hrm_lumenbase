<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Personal;

class UserController extends Controller
{
    public function index()
    {
        /*if (count(User::all()) < 1) {
            User::factory()->count(2)->create();
        }*/
        $users = DB::table('users')
                    ->join('personals', 'users.id', '=', 'personals.user_id')
                    ->select('users.id', 'users.email', 'personals.first_name', 'personals.last_name')
                    ->where('users.deleted_at', null)
                    ->get();

        return response()->json($users);
    }

    public function create(Request $request)
    {
        $validated = $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $profile = Personal::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'user_id' => $user->id
        ]);

        $code = 200;
        $output = [
            'code' => $code,
            'message' => 'User added!',
        ];

        return response()->json($output, $code);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $user = DB::table('users')
                    ->where('users.id', $user->id)
                    ->join('personals', 'users.id', '=', 'personals.user_id')
                    ->select('users.id', 'users.email', 'personals.first_name', 'personals.last_name')
                    ->first();

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $filteredRequest = array_filter($request->all());

        $user = Personal::where('user_id', $id)->update($filteredRequest);

        $code = 200;
        $output = [
            'code' => $code,
            'message' => 'User updated!',
        ];

        return response()->json($output, $code);
    }

    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        $personal = Personal::where('user_id', $user->id)->first()->delete();
        $user->delete();

        $users = DB::table('users')
                    ->join('personals', 'users.id', '=', 'personals.user_id')
                    ->select('users.id', 'users.email', 'personals.first_name', 'personals.last_name')
                    ->where('users.deleted_at', null)
                    ->get();

        $code = 200;
        $output = [
            'code' => $code,
            'message' => 'User deleted!',
            'data' => array(
              'users' => $users
            ),
        ];

        return response()->json($output, $code);
    }

    public function current()
    {
        $user = Auth::user();
        $user = DB::table('users')
                    ->where('users.id', $user->id)
                    ->join('personals', 'users.id', '=', 'personals.user_id')
                    ->select('users.id', 'users.email', 'personals.first_name', 'personals.last_name')
                    ->first();

        $code = 200;
        $output = [
            'code' => $code,
            'message' => 'Current user!',
            'data' => array(
              'user' => $user
            ),
        ];

        return response()->json($output, $code);
    }

    public function logout()
    {
        Auth::logout();

        $code = 200;
        $output = [
            'code' => $code,
            'message' => 'User logged out!'
        ];

        return response()->json($output, $code);
    }
}
