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
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('bank_account_number')->nullable()->after('client_contact_name');
            $table->string('ifsc_code')->nullable()->after('bank_account_number');
            $table->string('mobile_bank_number')->nullable()->after('ifsc_code');
            $table->string('company_pan')->nullable()->after('mobile_bank_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn(['bank_account_number', 'ifsc_code', 'mobile_bank_number', 'company_pan']);
        });
    }
};
