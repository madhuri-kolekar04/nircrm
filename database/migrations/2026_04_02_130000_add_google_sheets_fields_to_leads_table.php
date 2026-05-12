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
        Schema::table('leads', function (Blueprint $table) {
            $table->string('business_type')->nullable();
            $table->text('primary_goal')->nullable();
            $table->string('score')->nullable();
            $table->string('tier')->nullable();
            $table->date('submitted_at')->nullable();
            $table->text('audit_report')->nullable();
            $table->text('audit_report_plain')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'business_type',
                'primary_goal', 
                'score',
                'tier',
                'submitted_at',
                'audit_report',
                'audit_report_plain'
            ]);
        });
    }
};
