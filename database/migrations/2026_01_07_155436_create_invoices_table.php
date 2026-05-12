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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            
            // Project Details
            $table->string('project_name');
            $table->string('project_topic');
            $table->text('project_full_details');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('department');
            
            // Customer Details
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->text('customer_address');
            
            // Payment Details
            $table->decimal('advance_payment', 10, 2);
            $table->decimal('remaining_payment', 10, 2);
            $table->decimal('gst', 10, 2);
            $table->decimal('total_payment', 10, 2);
            
            // Invoice Details
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            
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
        Schema::dropIfExists('invoices');
    }
};
