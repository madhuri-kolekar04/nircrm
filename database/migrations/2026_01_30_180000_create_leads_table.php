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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company_name')->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('pincode')->nullable();
            $table->string('industry')->nullable();
            $table->enum('lead_status', ['hot', 'cold', 'warm', 'qualified', 'lost'])->default('cold');
            $table->enum('source', ['website', 'referral', 'social_media', 'email', 'phone', 'advertisement', 'other'])->default('other');
            $table->text('description')->nullable();
            $table->decimal('budget', 10, 2)->nullable();
            $table->string('assigned_to')->nullable(); // Employee ID
            $table->date('follow_up_date')->nullable();
            $table->text('notes')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->string('department')->nullable(); // Which department this lead belongs to
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
};
