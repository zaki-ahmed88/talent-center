<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


use App\Models\Role;
use App\Models\User;


use Illuminate\Support\Facades\Hash;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $roles = ['Admin', 'Teacher', 'Student', 'Support', 'Secretary'];

        foreach ($roles as $role){
            Role::create([
                'name' => $role,
            ]);
        }




        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '010000',
            'password' => Hash::make('12345678'),
            'status' => 0,
            'role_id' => 1,
        ]);




        User::create([
            'name' => 'Student',
            'email' => 'student@gmail.com',
            'phone' => '010000',
            'password' => Hash::make('12345678'),
            'status' => 0,
            'role_id' => 3,
        ]);
    }
}
