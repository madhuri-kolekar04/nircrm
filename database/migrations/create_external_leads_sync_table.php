<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('external_leads_sync', function (Blueprint $table) {
            $table->id();
            $table->string('external_database_name')->comment('Name of the external database');
            $table->string('external_table_name')->comment('Name of the external table');
            $table->unsignedBigInteger('external_lead_id')->comment('ID from external database');
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
            $table->string('lead_status')->default('cold');
            $table->string('source')->default('external_sync');
            $table->text('description')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->boolean('customer_panel')->default(false);
            $table->string('invoice_status')->nullable();
            $table->string('invoice_number')->nullable();
            $table->timestamp('invoice_created_at')->nullable();
            $table->text('notes')->nullable();
            $table->string('priority')->default('medium');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('department')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('business_type')->nullable();
            $table->string('primary_goal')->nullable();
            $table->integer('score')->nullable();
            $table->string('tier')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->text('audit_report')->nullable();
            $table->text('audit_report_plain')->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();

            // Indexes for performance
           $table->index(
    ['external_database_name', 'external_lead_id'],
    'ext_db_lead_idx'
);
            $table->index('last_synced_at');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_leads_sync');
    }
};
