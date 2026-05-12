<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if shift_id column doesn't exist before adding
            if (!Schema::hasColumn('users', 'shift_id')) {
                $table->unsignedBigInteger('shift_id')->nullable()->after('department_id');
                $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('set null');
            }
            
            // Check if deactivated_at column doesn't exist before adding
            if (!Schema::hasColumn('users', 'deactivated_at')) {
                $table->timestamp('deactivated_at')->nullable()->after('is_active');
            }
            
            // Check if deactivation_reason column doesn't exist before adding
            if (!Schema::hasColumn('users', 'deactivation_reason')) {
                $table->text('deactivation_reason')->nullable()->after('deactivated_at');
            }
            
            // Check if deactivated_by column doesn't exist before adding
            if (!Schema::hasColumn('users', 'deactivated_by')) {
                $table->unsignedBigInteger('deactivated_by')->nullable()->after('deactivation_reason');
                $table->foreign('deactivated_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['shift_id']);
            $table->dropForeign(['deactivated_by']);
            $table->dropColumn(['shift_id', 'deactivated_at', 'deactivation_reason', 'deactivated_by']);
        });
    }
};
