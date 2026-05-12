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
        Schema::create('employee_menu_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('menu_name');
            $table->string('menu_url');
            $table->string('menu_icon')->nullable();
            $table->integer('menu_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
            
            $table->unique(['employee_id', 'menu_name']);
            $table->index('employee_id');
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_menu_permissions');
    }
};
