<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Quotation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Update existing quotations with completed payment to have customer_panel = true
        Quotation::where('payment_status', 'completed')
                ->whereNull('customer_panel')
                ->update(['customer_panel' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // No need to reverse this data migration
    }
};
