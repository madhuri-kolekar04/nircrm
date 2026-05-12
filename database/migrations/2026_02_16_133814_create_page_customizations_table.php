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
        Schema::create('page_customizations', function (Blueprint $table) {
            $table->id();
            $table->string('menu_name');
            $table->string('menu_url');
            $table->integer('role_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->string('element_type'); // table, column, button, form, field
            $table->string('element_name');
            $table->string('element_identifier')->nullable(); // ID, class, or selector
            $table->boolean('is_visible')->default(true);
            $table->json('element_metadata')->nullable(); // Additional details
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['menu_name', 'role_id']);
            $table->index(['menu_name', 'employee_id']);
            $table->index(['element_type', 'element_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_customizations');
    }
};
