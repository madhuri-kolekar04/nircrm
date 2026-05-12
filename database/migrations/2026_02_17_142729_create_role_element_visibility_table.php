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
        Schema::create('role_element_visibility', function (Blueprint $table) {
            $table->id();
            $table->string('page_url')->index();
            $table->integer('role_id');
            $table->string('element_type');
            $table->string('element_identifier');
            $table->string('element_name');
            $table->boolean('is_visible')->default(true);
            $table->json('element_metadata')->nullable();
            $table->timestamps();
            
            $table->index(['page_url', 'role_id']);
            $table->index(['role_id', 'element_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_element_visibility');
    }
};
