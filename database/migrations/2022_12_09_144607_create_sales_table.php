<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Exceptions\Handler;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('comapny_name')->nullable();
            $table->string('profile_photo_path')->nullable();
            $table->string('location')->nullable();
            $table->string('service')->nullable();
            $table->integer('contact_number')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('google_sheet_link')->nullable();
            $table->integer('role')->nullable();
            $table->string('department');
            $table->integer('pm')->nullable();
            $table->integer('seo')->nullable();
            $table->integer('dm')->nullable();
            $table->string('client_coordinator')->nullable();
            $table->string('coordinator_contact')->nullable();
            $table->string('coordinator_email')->nullable();

            $table->integer('employee_id')->nullable();
            $table->string('manager_name')->nullable();
            $table->string('client_one')->nullable();
            $table->string('client_two')->nullable();
            $table->string('client_three')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('sales');
    }
};
