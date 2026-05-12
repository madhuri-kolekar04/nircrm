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
        Schema::create('lead_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('reaction_type', ['positive', 'neutral', 'negative', 'follow_up', 'interested', 'not_reachable']);
            $table->text('notes')->nullable();
            $table->date('reaction_date');
            $table->time('reaction_time');
            $table->date('next_follow_up')->nullable();
            $table->integer('call_duration')->nullable()->comment('Call duration in seconds');
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['lead_id', 'reaction_date']);
            $table->index('user_id');
            $table->index('reaction_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_reactions');
    }
};
