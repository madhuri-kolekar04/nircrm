<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApprovalStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ApprovalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing approval status records
        DB::table('approval_status')->delete();

        // Get users for creating sample data
        $admin = User::where('role', 1)->first();
        $employee = User::where('role', 2)->first();
        $manager = User::where('position', 'Manager')->first();
        $customer = User::where('role', 3)->first();

        if (!$admin || !$employee || !$manager) {
            $this->command->error('Required users not found. Please ensure you have admin, employee, and manager users.');
            return;
        }

        // Sample approval requests
        $approvals = [
            [
                'action_type' => 'delete',
                'target_type' => 'employee',
                'target_id' => $employee->id,
                'target_data' => $employee->toArray(),
                'requested_by' => $employee->id,
                'status' => 'pending',
                'reason' => 'Request to remove employee account due to resignation',
                'required_approvals' => [$manager->id, $admin->id],
                'current_approvals' => [],
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'action_type' => 'update',
                'target_type' => 'employee',
                'target_id' => $employee->id,
                'target_data' => $employee->toArray(),
                'requested_by' => $employee->id,
                'status' => 'pending',
                'reason' => 'Request to update employee profile information',
                'required_approvals' => [$manager->id],
                'current_approvals' => [],
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'action_type' => 'create',
                'target_type' => 'customer',
                'target_id' => $customer ? $customer->id : 1,
                'target_data' => $customer ? $customer->toArray() : ['name' => 'Sample Customer'],
                'requested_by' => $employee->id,
                'status' => 'approved',
                'reason' => 'Request to create new customer account',
                'required_approvals' => [$manager->id],
                'current_approvals' => [$manager->id],
                'approved_at' => now()->subHours(3),
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subHours(3),
            ],
            [
                'action_type' => 'delete',
                'target_type' => 'customer',
                'target_id' => $customer ? $customer->id : 1,
                'target_data' => $customer ? $customer->toArray() : ['name' => 'Sample Customer'],
                'requested_by' => $manager->id,
                'status' => 'rejected',
                'reason' => 'Request to delete inactive customer account',
                'required_approvals' => [$admin->id],
                'current_approvals' => [],
                'rejection_reason' => 'Customer account cannot be deleted due to pending transactions',
                'rejected_at' => now()->subHours(6),
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subHours(6),
            ],
            [
                'action_type' => 'update',
                'target_type' => 'employee',
                'target_id' => $admin->id,
                'target_data' => $admin->toArray(),
                'requested_by' => $manager->id,
                'status' => 'pending',
                'reason' => 'Request to update admin contact information',
                'required_approvals' => [$admin->id],
                'current_approvals' => [],
                'created_at' => now()->subHours(12),
                'updated_at' => now()->subHours(12),
            ],
        ];

        foreach ($approvals as $approval) {
            ApprovalStatus::create($approval);
        }

        $this->command->info('Sample approval status records created successfully!');
    }
}
