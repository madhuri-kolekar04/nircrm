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
    if (!Schema::hasColumn('project_updates', 'attachment')) {
        Schema::table('project_updates', function (Blueprint $table) {
            $table->string('attachment')->nullable()->after('task_priority');
        });
    }
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
   public function down()
{
    if (Schema::hasColumn('project_updates', 'attachment')) {
        Schema::table('project_updates', function (Blueprint $table) {
            $table->dropColumn('attachment');
        });
    }
}
};
