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
        Schema::create('menu_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('menu_name');
            $table->string('menu_url');
            $table->string('menu_icon')->nullable();
            $table->integer('menu_order')->default(0);
            $table->integer('role_id');
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
            
            $table->unique(['menu_name', 'role_id']);
            $table->index('role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_permissions');
    }
};
