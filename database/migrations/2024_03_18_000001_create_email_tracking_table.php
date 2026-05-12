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
        Schema::create('email_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->string('invoice_number');
            $table->string('recipient_email');
            $table->string('approval_token')->unique();
            $table->enum('email_type', ['invoice_approval', 'reminder', 'custom'])->default('invoice_approval');
            $table->enum('status', ['pending', 'approved', 'rejected', 'expired'])->default('pending');
            $table->timestamp('sent_at');
            $table->timestamp('responded_at')->nullable();
            $table->string('response_ip')->nullable();
            $table->text('notes')->nullable();
            $table->integer('attempts')->default(1);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            $table->index(['lead_id', 'status']);
            $table->index(['approval_token']);
            $table->index(['expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_tracking');
    }
};
