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
        Schema::create('approval_status', function (Blueprint $table) {
            $table->id();
            $table->string('action_type'); // delete, update, create
            $table->string('target_type'); // employee, customer, etc.
            $table->unsignedBigInteger('target_id'); // ID of the record being acted upon
            $table->json('target_data')->nullable(); // Store the data being acted upon
            $table->unsignedBigInteger('requested_by'); // User who requested the action
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('reason')->nullable(); // Reason for action
            $table->json('approval_chain')->nullable(); // Store the approval hierarchy
            $table->json('current_approvals')->nullable(); // Track who has approved
            $table->json('required_approvals')->nullable(); // Required approvers based on hierarchy
            $table->text('rejection_reason')->nullable(); // Reason for rejection
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->index(['status', 'target_type']);
            $table->index(['requested_by']);
            $table->index(['target_type', 'target_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('approval_status');
    }
};
