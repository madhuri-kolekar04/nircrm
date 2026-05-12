<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Department;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Fix existing department data inconsistency
        $this->fixDepartmentData();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No reverse needed for data fix
    }

    private function fixDepartmentData()
    {
        // Check if department column exists
        if (!Schema::hasColumn('users', 'department')) {
            return; // Skip if column doesn't exist
        }
        
        // Get all departments for reference
        $departments = Department::all()->pluck('department', 'id')->toArray();
        
        // Fix users with numeric department IDs
        $usersWithNumericDept = User::whereNotNull('department')
            ->where('department', '!=', '')
            ->whereRaw("CAST(department AS SIGNED) > 0")
            ->get();

        foreach ($usersWithNumericDept as $user) {
            if (is_numeric($user->department)) {
                $dept = Department::find($user->department);
                if ($dept) {
                    $user->department = $dept->department;
                    $user->save();
                }
            }
        }

        // Create missing departments
        $uniqueDepartments = User::whereNotNull('department')
            ->where('department', '!=', '')
            ->whereNotIn('department', array_values($departments))
            ->distinct()
            ->pluck('department');

        foreach ($uniqueDepartments as $deptName) {
            // Only create departments that don't exist and are not generic
            if (!in_array($deptName, ['Customer', 'IT', 'Operations', 'Administration'])) {
                Department::create(['department' => $deptName]);
            }
        }
    }
};
