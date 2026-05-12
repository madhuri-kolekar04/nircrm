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
        Schema::create('employee_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('task_date');
            $table->text('task_description');
            $table->string('client_project_name');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'stopped', 'on_hold'])->default('pending');
            $table->integer('task_number')->default(1);
            $table->timestamps();
            
            $table->index(['user_id', 'task_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_tasks');
    }
};
