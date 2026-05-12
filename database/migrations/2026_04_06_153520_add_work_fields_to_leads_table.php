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
            $table->string('work_status')->nullable()->after('notes');
            $table->string('work_type')->nullable()->after('work_status');
            $table->string('current_service')->nullable()->after('work_type');
            $table->date('date_of_completion')->nullable()->after('current_service');
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
