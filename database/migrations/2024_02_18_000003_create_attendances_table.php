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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->enum('status', ['present', 'absent', 'half_day', 'on_leave', 'holiday', 'weekend'])->default('present');
            $table->decimal('working_hours', 5, 2)->nullable(); // Total working hours
            $table->decimal('overtime_hours', 5, 2)->nullable(); // Overtime hours
            $table->text('notes')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_late')->default(false);
            $table->boolean('is_early_checkout')->default(false);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['user_id', 'date']);
            $table->index(['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
