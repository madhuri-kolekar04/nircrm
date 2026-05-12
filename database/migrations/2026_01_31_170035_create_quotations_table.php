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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_number')->unique();
            $table->string('client_business_name');
            $table->string('client_email');
            $table->string('client_phone');
            $table->string('client_contact_name');
            $table->text('executive_summary');
            $table->decimal('total_cost', 10, 2);
            $table->decimal('gst_amount', 10, 2)->default(0);
            $table->decimal('final_amount', 10, 2);
            $table->enum('status', ['draft', 'sent', 'approved', 'rejected'])->default('draft');
            $table->date('valid_until')->nullable();
            $table->text('terms_conditions')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('lead_id')->nullable()->constrained('leads');
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
        Schema::dropIfExists('quotations');
    }
};
