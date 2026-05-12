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
        Schema::create('reactions_system', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            
            // Reaction details
            $table->enum('reaction_type', [
                'positive', 'neutral', 'negative', 'follow_up', 
                'interested', 'not_reachable', 'hot_lead', 'cold_lead', 
                'appointment_set', 'meeting_scheduled', 'proposal_sent',
                'negotiation', 'closed_won', 'closed_lost'
            ])->default('neutral');
            
            $table->text('notes')->nullable();
            $table->text('reaction_details')->nullable();
            
            // Timing information
            $table->date('reaction_date')->default(now()->toDateString());
            $table->time('reaction_time')->default(now()->toTimeString());
            $table->timestamp('reaction_timestamp')->default(now());
            
            // Follow-up management
            $table->date('next_follow_up')->nullable();
            $table->time('follow_up_time')->nullable();
            $table->enum('follow_up_priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->text('follow_up_notes')->nullable();
            
            // Call details
            $table->integer('call_duration')->nullable()->comment('Duration in seconds');
            $table->string('call_type')->nullable()->comment('incoming, outgoing, missed');
            $table->string('phone_number')->nullable();
            
            // Meeting details
            $table->date('meeting_date')->nullable();
            $table->time('meeting_time')->nullable();
            $table->string('meeting_location')->nullable();
            $table->text('meeting_agenda')->nullable();
            
            // Status and priority
            $table->enum('status', ['active', 'completed', 'cancelled', 'postponed'])->default('active');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->integer('rating')->nullable()->comment('1-5 scale rating');
            
            // Additional metadata
            $table->string('source')->nullable()->comment('Source of reaction: phone, email, website, etc.');
            $table->string('campaign')->nullable()->comment('Marketing campaign if applicable');
            $table->decimal('value', 10, 2)->nullable()->comment('Potential deal value');
            $table->text('tags')->nullable()->comment('Comma-separated tags');
            
            // Notification settings
            $table->boolean('email_sent')->default(false);
            $table->boolean('sms_sent')->default(false);
            $table->boolean('notification_sent')->default(false);
            $table->timestamp('last_notification_sent')->nullable();
            
            // System fields
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index(['lead_id', 'reaction_date'], 'idx_lead_date');
            $table->index(['user_id', 'reaction_date'], 'idx_user_date');
            $table->index(['reaction_type', 'status'], 'idx_type_status');
            $table->index(['next_follow_up', 'status'], 'idx_followup_status');
            $table->index(['priority', 'reaction_date'], 'idx_priority_date');
            
            // Foreign key constraints
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reactions_system');
    }
};
