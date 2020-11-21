<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index()
    {
        return response()->json([
            'name' => 'Ezichi Ebere', 
            'title' => 'Web Developer'
        ]);
    }
}