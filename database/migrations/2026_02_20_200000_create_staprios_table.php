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
        Schema::create('staprios', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Hot", "Cold", "High", "Medium"
            $table->string('value'); // e.g., "hot", "cold", "high", "medium" (for database storage)
            $table->enum('type', ['status', 'priority']); // Type: status or priority
            $table->string('color')->nullable(); // Color code for UI (e.g., "#dc3545", "#ffc107")
            $table->boolean('is_protected')->default(false); // Protected items cannot be deleted (e.g., "Qualified")
            $table->integer('sort_order')->default(0); // For ordering in dropdowns
            $table->boolean('is_active')->default(true); // Enable/disable options
            $table->timestamps();
            
            // Indexes
            $table->index(['type', 'is_active'], 'idx_type_active');
            $table->index(['type', 'sort_order'], 'idx_type_sort');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staprios');
    }
};
