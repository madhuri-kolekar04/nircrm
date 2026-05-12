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
            // Add best calling time columns
            $table->string('best_calling_time_range')->nullable()->after('priority');
            $table->string('best_calling_time_confidence')->nullable()->after('best_calling_time_range');
            $table->string('best_calling_time_peak_hour')->nullable()->after('best_calling_time_confidence');
            $table->integer('best_calling_interaction_count')->default(0)->after('best_calling_time_peak_hour');
            $table->text('best_calling_time_reason')->nullable()->after('best_calling_interaction_count');
            $table->string('best_calling_time_color')->nullable()->after('best_calling_time_reason');
            $table->timestamp('best_calling_time_calculated_at')->nullable()->after('best_calling_time_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'best_calling_time_range',
                'best_calling_time_confidence', 
                'best_calling_time_peak_hour',
                'best_calling_interaction_count',
                'best_calling_time_reason',
                'best_calling_time_color',
                'best_calling_time_calculated_at'
            ]);
        });
    }
};
