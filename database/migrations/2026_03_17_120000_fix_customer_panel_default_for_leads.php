<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update all existing leads to have customer_panel set to false by default
        // This ensures that the Customer Panel shows as "disabled" by default in the UI
        DB::table('leads')
            ->where('customer_panel', true)
            ->update(['customer_panel' => false]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Reverse: Set all leads back to true (if needed for rollback)
        // Note: This is a simplified rollback - in practice you might want to track original values
        DB::table('leads')
            ->where('customer_panel', false)
            ->update(['customer_panel' => true]);
    }
};
