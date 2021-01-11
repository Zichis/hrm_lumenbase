<?php

namespace Database\Seeders;

use App\Models\User;
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
            'password' => Hash::make('password')
        ]);

        $profile1 = Personal::create([
            'first_name' => 'Ezichi',
            'last_name' => 'Ezichi',
            'user_id' => $user1->id
        ]);

        // User 2
        $user2 = User::create([
            'email' => 'janedoe@gmail.com',
            'password' => Hash::make('password')
        ]);

        $profile1 = Personal::create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'user_id' => $user2->id
        ]);
    }
}
