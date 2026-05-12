<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\User;
use Carbon\Carbon;

class LeaveDemoSeeder extends Seeder
{
    public function run()
    {
        // Get or create leave types
        $leaveTypes = [
            ['name' => 'Sick Leave', 'max_days_per_year' => 12, 'is_paid' => true, 'is_active' => true],
            ['name' => 'Casual Leave', 'max_days_per_year' => 15, 'is_paid' => true, 'is_active' => true],
            ['name' => 'Annual Leave', 'max_days_per_year' => 21, 'is_paid' => true, 'is_active' => true],
            ['name' => 'Maternity Leave', 'max_days_per_year' => 90, 'is_paid' => true, 'is_active' => true],
        ];

        foreach ($leaveTypes as $type) {
            LeaveType::firstOrCreate(['name' => $type['name']], $type);
        }

        // Get some users for demo data
        $users = User::where('is_active', true)->take(5)->get();
        
        if ($users->isEmpty()) {
            // Create demo users if none exist
            $users = collect([
                User::firstOrCreate(['email' => 'john.doe@example.com'], [
                    'name' => 'John',
                    'last_name' => 'Doe',
                    'password' => bcrypt('password'),
                    'role' => 3, // Employee
                    'is_active' => true,
                    'department_id' => 1,
                ]),
                User::firstOrCreate(['email' => 'jane.smith@example.com'], [
                    'name' => 'Jane',
                    'last_name' => 'Smith',
                    'password' => bcrypt('password'),
                    'role' => 4, // Manager
                    'is_active' => true,
                    'department_id' => 1,
                ]),
            ]);
        }

        // Get an admin user for approvals
        $adminUser = User::where('role', 1)->first();
        if (!$adminUser) {
            $adminUser = $users->first(); // Use first user as admin if none exists
        }

        // Create demo leave data
        $leaveTypeIds = LeaveType::pluck('id')->toArray();
        
        foreach ($users as $user) {
            // Create some approved leaves
            for ($i = 0; $i < 2; $i++) {
                Leave::create([
                    'user_id' => $user->id,
                    'leave_type_id' => $leaveTypeIds[array_rand($leaveTypeIds)],
                    'start_date' => Carbon::now()->subDays(rand(5, 15)),
                    'end_date' => Carbon::now()->subDays(rand(1, 10)),
                    'total_days' => rand(1, 5),
                    'reason' => 'Personal leave request',
                    'status' => 'approved',
                    'approver_id' => $adminUser->id,
                    'approval_date' => Carbon::now()->subDays(rand(1, 5)),
                ]);
            }
            
            // Create some pending leaves
            Leave::create([
                'user_id' => $user->id,
                'leave_type_id' => $leaveTypeIds[array_rand($leaveTypeIds)],
                'start_date' => Carbon::now()->addDays(rand(5, 15)),
                'end_date' => Carbon::now()->addDays(rand(6, 20)),
                'total_days' => rand(1, 5),
                'reason' => 'Upcoming leave request',
                'status' => 'pending',
            ]);
            
            // Create some rejected leaves
            Leave::create([
                'user_id' => $user->id,
                'leave_type_id' => $leaveTypeIds[array_rand($leaveTypeIds)],
                'start_date' => Carbon::now()->subDays(rand(20, 30)),
                'end_date' => Carbon::now()->subDays(rand(15, 25)),
                'total_days' => rand(1, 3),
                'reason' => 'Rejected leave request',
                'status' => 'rejected',
                'approver_id' => $adminUser->id,
                'approval_date' => Carbon::now()->subDays(rand(10, 20)),
                'rejection_reason' => 'Insufficient notice period',
            ]);
        }
        
        echo "Demo leave data created successfully!\n";
    }
}
