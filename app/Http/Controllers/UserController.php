<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        if (count(User::all()) < 1) {
            User::factory()->count(2)->create();
        }
        
        return response()->json(User::all());
    }
}
