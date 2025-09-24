<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'first_name' => 'Super',
                'last_name'  => 'Admin',
                'email'      => 'admin@example.com',
                'password'   => Hash::make('password123'),
                'phonenumber'=> '9876543210',
                'is_admin'   => 1,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'email'      => 'john@example.com',
                'password'   => Hash::make('password123'),
                'phonenumber'=> '9123456780',
                'is_admin'   => 0,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
