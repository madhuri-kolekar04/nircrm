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
        Schema::table('lead_reactions', function (Blueprint $table) {
            $table->boolean('notification_sent')->default(false)->after('reaction_time');
            $table->timestamp('notification_sent_at')->nullable()->after('notification_sent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lead_reactions', function (Blueprint $table) {
            $table->dropColumn(['notification_sent', 'notification_sent_at']);
        });
    }
};
