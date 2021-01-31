<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class UserRepository
{
  public function usersWithPersonal()
  {
    return DB::table('users')
      ->join('personals', 'users.id', '=', 'personals.user_id')
      ->select('users.id', 'users.email', 'personals.first_name', 'personals.last_name')
      ->where('users.deleted_at', null)
      ->get();
  }

  public function userWithPersonal(int $userId)
  {
    return DB::table('users')
      ->where('users.id', $userId)
      ->join('personals', 'users.id', '=', 'personals.user_id')
      ->select('users.id', 'users.email', 'personals.first_name', 'personals.last_name')
      ->first();
  }
}
