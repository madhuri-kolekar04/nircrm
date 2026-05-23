<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('leads', function (Blueprint $table) {

        if (!Schema::hasColumn('leads', 'work_status')) {
            $table->string('work_status')->nullable()->after('notes');
        }

        if (!Schema::hasColumn('leads', 'work_type')) {
            $table->string('work_type')->nullable()->after('work_status');
        }

        if (!Schema::hasColumn('leads', 'current_service')) {
            $table->string('current_service')->nullable()->after('work_type');
        }

        if (!Schema::hasColumn('leads', 'date_of_completion')) {
            $table->date('date_of_completion')->nullable()->after('current_service');
        }

    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['work_status', 'work_type', 'current_service', 'date_of_completion']);
        });
    }
};
