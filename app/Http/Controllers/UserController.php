<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Personal;
use App\Repository\UserRepository;
use App\Service\UserService;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(
        UserRepository $userRepository,
        UserService $userService
    ) {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userRepository->getUsers();

        return response()->json($users);
    }

    public function create(Request $request)
    {
        $validated = $this->validate(
            $request,
            [
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'department_id' => 'required|integer'
            ]
        );

        $user = User::create(
            [
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department_id' => $request->department_id
            ]
        );

        $admin = filter_var($request->input('admin'), FILTER_VALIDATE_BOOLEAN);

        if ($admin) {
            $user->roles()->attach([1]);
        }

        $user->roles()->attach([2]); // User role

        $profile = Personal::create(
            [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'user_id' => $user->id
            ]
        );

        $code = 200;
        $output = [
            'code' => $code,
            'message' => 'User added!',
        ];

        return response()->json($output, $code);
    }

    public function show($id)
    {
        $user = User::with(['personal','roles'])->findOrFail($id);
        //$user = $this->userRepository->userWithPersonal($user->id);

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        // TODO: Reduce/Refactor this controller
        $filteredRequest = array_filter($request->all());

        $personal = Personal::where('user_id', $id)->update([
            'first_name' => $filteredRequest['first_name'],
            'last_name' => $filteredRequest['last_name']
        ]);

        $adminUsers = User::whereHas(
            'roles', function($q){
                $q->where('name', 'ROLE_ADMIN');
            }
        )->count();

        $user = User::find($id);
        $user->update([
            'department_id' => $filteredRequest['department_id']
        ]);
        $user->roles()->sync([1,2]);

        $admin = filter_var($request->input('admin'), FILTER_VALIDATE_BOOLEAN);

        if ($adminUsers == 1 && !$admin) {
            return response()->json(['message' => 'There should be an admin user!'], 401);
        }

        if (!$admin) {
            $user->roles()->sync([2]);
        }

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
        // TODO: Check if archived_email exists
        $user->email = 'archived_' . $user->email;
        $user->save();
        $user->delete();

        $users = User::with(['personal', 'roles'])->where('users.deleted_at', null)->get();

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
        $userLogged = Auth::user();
        $user = User::with(['personal'])->find($userLogged->id);

        $code = 200;
        $output = $this->userService->responseMessage(
            'Current user!',
            array(
                'user' => $user
            )
        );

        return response()->json($output, $code);
    }

    public function onboard(Request $request)
    {
        if (User::where('deleted_at', 0)->count() > 0) {
            $code = 403;
            $output = [
                'code' => $code,
                'message' => 'Admin exist!',
            ];

            return response()->json($output, $code);
        }

        $validated = $this->validate(
            $request,
            [
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'first_name' => 'required',
                'last_name' => 'required'
            ]
        );

        $user = User::create(
            [
            'email' => $request->email,
            'password' => Hash::make($request->password)
            ]
        );

        $user->roles()->attach([1, 2]); // Admin role

        $profile = Personal::create(
            [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'user_id' => $user->id
            ]
        );

        $code = 200;
        $output = [
            'code' => $code,
            'message' => 'User added!',
        ];

        return response()->json($output, $code);
    }

    public function count()
    {
        $code = 200;
        $output = [
            'code' => $code,
            'message' => 'Number of users',
            'data' => array(
              'users' => count($this->userRepository->getusers())
            ),
        ];

        return response()->json($output, $code);
    }

    public function roles()
    {
        $code = 200;
        $output = [
            'message' => 'User roles',
            'data' => array(
              'roles' => Auth::user()->rolesNames()
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
