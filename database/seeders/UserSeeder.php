<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'user_id' => '1',
                'first_name' => 'Student',
                'Last_name' => 'Student',
                'usn' => '19000',
                'password_hash' => Hash::make('password1'),
                'email' => 'gambaza@gmail.com',
                'phone_number' => '123456789',
                'profile_picture' => null,
                'last_login' => null,
                'role' => 'student',
                'is_active' => '1',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'user_id' => '2',
                'first_name' => 'Manet',
                'Last_name' => 'Ostia',
                'usn' => '10000',
                'password_hash' => Hash::make('password1'),
                'email' => 'teacher@gmail.com',
                'phone_number' => '123456789',
                'profile_picture' => null,
                'last_login' => null,
                'role' => 'teacher',
                'is_active' => '1',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'user_id' => '3',
                'first_name' => 'Donald',
                'Last_name' => 'Fransisco',
                'usn' => 'admin',
                'password_hash' => Hash::make('password1'),
                'email' => 'admin@gmail.com',
                'phone_number' => '123456789',
                'profile_picture' => null,
                'last_login' => null,
                'role' => 'admin',
                'is_active' => '1',
                'created_at' => now(),
                'updated_at' => null,
            ],
        ]);
    }
}
