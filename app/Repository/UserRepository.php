<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function getUsers()
    {
        return User::with(
            [
            'personal',
            'roles'
            ]
        )->where('users.deleted_at', null)->get();
    }
}
