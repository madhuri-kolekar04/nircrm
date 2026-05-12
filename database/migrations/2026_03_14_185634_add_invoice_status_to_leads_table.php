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
        Schema::table('leads', function (Blueprint $table) {
            $table->string('invoice_status')->default('waiting for approval')->after('customer_panel');
            $table->string('invoice_number')->nullable()->after('invoice_status');
            $table->timestamp('invoice_created_at')->nullable()->after('invoice_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['invoice_status', 'invoice_number', 'invoice_created_at']);
        });
    }
};
