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
        Schema::table('quotations', function (Blueprint $table) {
            // Make id column auto-increment and primary key
            $table->unsignedBigInteger('id')->autoIncrement()->primary()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotations', function (Blueprint $table) {
            // This is a bit tricky to reverse, but we'll try to remove auto_increment
            $table->unsignedBigInteger('id')->primary()->change();
        });
    }
};
