<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Test Admin',
                'password' => \Hash::make('password'),
                'role' => 1,
                'position' => 'Administrator',
                'department' => 'IT',
                'group' => 'Support',
                'employee_id' => 1001,
                'contact_number' => '1234567890',
                'location' => 'Office'
            ]
        );
        
        \App\Models\User::updateOrCreate(
            ['email' => 'manager@test.com'],
            [
                'name' => 'Test Manager',
                'password' => \Hash::make('password'),
                'role' => 4,
                'position' => 'Manager',
                'department' => 'Operations',
                'group' => 'Management',
                'employee_id' => 1002,
                'contact_number' => '1234567891',
                'location' => 'Office'
            ]
        );
        
        \App\Models\User::updateOrCreate(
            ['email' => 'user@test.com'],
            [
                'name' => 'Test User',
                'password' => \Hash::make('password'),
                'role' => 2,
                'position' => 'Employee',
                'department' => 'Support',
                'group' => 'Team A',
                'employee_id' => 1003,
                'contact_number' => '1234567892',
                'location' => 'Office'
            ]
        );
    }
}
