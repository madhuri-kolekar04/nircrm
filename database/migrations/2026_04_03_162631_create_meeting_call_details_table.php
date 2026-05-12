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
        Schema::create('meeting_call_details', function (Blueprint $table) {
            $table->id();
            $table->string('lead_full_name');
            $table->string('lead_business_name');
            $table->string('lead_email');
            $table->string('lead_whatsapp');
            $table->string('lead_website_url');
            $table->string('called_by_employee_name');
            $table->string('called_by_employee_email');
            $table->integer('rating'); // 1-5 star rating
            $table->text('meeting_conclusion'); // Point-wise conclusion
            $table->datetime('next_call_date')->nullable(); // Optional next call date
            $table->text('additional_notes')->nullable(); // Additional notes
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('lead_email');
            $table->index('called_by_employee_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meeting_call_details');
    }
};
