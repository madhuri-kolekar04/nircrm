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
        Schema::create('department_menu_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->string('menu_key'); // e.g., 'dashboard', 'leads', 'employees'
            $table->string('menu_title'); // e.g., 'Dashboard', 'Leads Generation', 'Employees'
            $table->string('menu_icon'); // e.g., 'fas fa-gauge-high'
            $table->string('menu_route'); // e.g., 'admin.dashboard', 'leads.index'
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->index(['department_id', 'menu_key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_menu_assignments');
    }
};
