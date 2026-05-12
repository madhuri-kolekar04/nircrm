<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create or update admin user
        User::updateOrCreate(
            ['email' => 'admins@gmail.com'],
            [
                'name' => 'Admin User',
                'email' => 'admins@gmail.com',
                'password' => Hash::make('123456789'),
                'role' => 1, // Admin role
                'position' => 'Admin',
                'department' => 'Administration',
                'employeeID' => 'admin',
            ]
        );

        // Create or update manager user
        User::updateOrCreate(
            ['email' => 'manager@gmail.com'],
            [
                'name' => 'Manager User',
                'email' => 'manager@gmail.com',
                'password' => Hash::make('123456789'),
                'role' => 4, // Manager role
                'position' => 'Manager',
                'department' => 'Management',
                'employeeID' => 'manager',
            ]
        );
    }
}
