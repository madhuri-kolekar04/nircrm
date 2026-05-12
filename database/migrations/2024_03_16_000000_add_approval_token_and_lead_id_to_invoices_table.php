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
        if (Schema::hasTable('invoices')) {
            Schema::table('invoices', function (Blueprint $table) {
                if (!Schema::hasColumn('invoices', 'approval_token')) {
                    $table->string('approval_token')->nullable()->after('notes');
                    $table->index('approval_token');
                }
                
                if (!Schema::hasColumn('invoices', 'approved_at')) {
                    $table->timestamp('approved_at')->nullable()->after('approval_token');
                }
                
                if (!Schema::hasColumn('invoices', 'lead_id')) {
                    $table->unsignedBigInteger('lead_id')->nullable()->after('approved_at');
                    $table->foreign('lead_id')->references('id')->on('leads')->onDelete('set null');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['lead_id']);
            $table->dropIndex(['approval_token']);
            $table->dropColumn(['approval_token', 'approved_at', 'lead_id']);
        });
    }
};
