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
        Schema::table('invoices', function (Blueprint $table) {
            // Add missing columns that are referenced in the code but don't exist
            if (!Schema::hasColumn('invoices', 'place_of_supply')) {
                $table->string('place_of_supply')->nullable();
            }
            
            if (!Schema::hasColumn('invoices', 'hsn_code')) {
                $table->string('hsn_code')->nullable();
            }
            
            if (!Schema::hasColumn('invoices', 'payment_terms')) {
                $table->text('payment_terms')->nullable();
            }
            
            if (!Schema::hasColumn('invoices', 'privacy_policy')) {
                $table->text('privacy_policy')->nullable();
            }
            
            if (!Schema::hasColumn('invoices', 'bank_account_number')) {
                $table->string('bank_account_number')->nullable();
            }
            
            if (!Schema::hasColumn('invoices', 'ifsc_code')) {
                $table->string('ifsc_code')->nullable();
            }
            
            if (!Schema::hasColumn('invoices', 'mobile_bank_number')) {
                $table->string('mobile_bank_number')->nullable();
            }
            
            if (!Schema::hasColumn('invoices', 'company_pan')) {
                $table->string('company_pan')->nullable();
            }
            
            if (!Schema::hasColumn('invoices', 'gst_number')) {
                $table->string('gst_number')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $columns = [
                'place_of_supply',
                'hsn_code', 
                'payment_terms',
                'privacy_policy',
                'bank_account_number',
                'ifsc_code',
                'mobile_bank_number',
                'company_pan',
                'gst_number'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('invoices', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
