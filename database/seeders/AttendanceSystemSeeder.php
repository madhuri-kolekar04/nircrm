<?php

use Illuminate\Database\Seeder;
use App\Models\LeaveType;
use App\Models\Department;

class AttendanceSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Leave Types
        $leaveTypes = [
            [
                'name' => 'Sick Leave',
                'description' => 'Leave for medical reasons',
                'max_days_per_year' => 12,
                'requires_approval' => true,
                'is_paid' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Casual Leave',
                'description' => 'Leave for personal reasons',
                'max_days_per_year' => 12,
                'requires_approval' => true,
                'is_paid' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Annual Leave',
                'description' => 'Yearly vacation leave',
                'max_days_per_year' => 21,
                'requires_approval' => true,
                'is_paid' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Maternity Leave',
                'description' => 'Leave for maternity',
                'max_days_per_year' => 180,
                'requires_approval' => true,
                'is_paid' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Paternity Leave',
                'description' => 'Leave for paternity',
                'max_days_per_year' => 15,
                'requires_approval' => true,
                'is_paid' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Unpaid Leave',
                'description' => 'Leave without pay',
                'max_days_per_year' => null,
                'requires_approval' => true,
                'is_paid' => false,
                'sort_order' => 6,
            ],
        ];

        foreach ($leaveTypes as $leaveType) {
            LeaveType::firstOrCreate(
                ['name' => $leaveType['name']],
                $leaveType
            );
        }

        // Create Departments (if they don't exist)
        $departments = [
            [
                'name' => 'Management',
                'description' => 'Management and Administration',
                'parent_id' => null,
            ],
            [
                'name' => 'Human Resources',
                'description' => 'HR Department',
                'parent_id' => null,
            ],
            [
                'name' => 'IT Department',
                'description' => 'Information Technology',
                'parent_id' => null,
            ],
            [
                'name' => 'Sales',
                'description' => 'Sales and Marketing',
                'parent_id' => null,
            ],
            [
                'name' => 'Finance',
                'description' => 'Finance and Accounts',
                'parent_id' => null,
            ],
        ];

        foreach ($departments as $department) {
            Department::firstOrCreate(
                ['name' => $department['name']],
                $department
            );
        }

        $this->command->info('Attendance system seed data created successfully!');
    }
}
