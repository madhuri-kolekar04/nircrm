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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'pan_number')) {
                $table->string('pan_number')->nullable();
            }
            if (!Schema::hasColumn('users', 'aadhar_number')) {
                $table->string('aadhar_number')->nullable();
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
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'pan_number')) {
                $table->dropColumn('pan_number');
            }
            if (Schema::hasColumn('users', 'aadhar_number')) {
                $table->dropColumn('aadhar_number');
            }
        });
    }
};
