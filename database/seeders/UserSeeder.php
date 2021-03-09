<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Personal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User 1
        $user1 = User::create([
            'email' => 'ezichiofficial@gmail.com',
            'password' => Hash::make('password'),
            'department_id' => 1
        ]);

        $profile1 = Personal::create([
            'first_name' => 'Ezichi',
            'last_name' => 'Ezichi',
            'user_id' => $user1->id
        ]);

        $adminRole = Role::find(1);
        $userRole = Role::find(2);
        $user1->roles()->attach([$adminRole->id, $userRole->id]);

        // User 2
        $user2 = User::create([
            'email' => 'janedoe@gmail.com',
            'password' => Hash::make('password'),
            'department_id' => 2
        ]);

        $profile1 = Personal::create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'user_id' => $user2->id
        ]);

        $user2->roles()->attach([$userRole->id]);
    }
}
