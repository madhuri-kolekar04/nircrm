<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->string('name', 100)->after('id');
            $table->time('start_time')->after('name');
            $table->time('end_time')->after('start_time');
            $table->integer('grace_period_minutes')->default(15)->after('end_time');
            $table->boolean('is_active')->default(true)->after('grace_period_minutes');
            $table->text('description')->nullable()->after('is_active');
        });

        // Insert default shifts if table is empty
        if (\DB::table('shifts')->count() == 0) {
            \DB::table('shifts')->insert([
                [
                    'name' => 'Morning Shift',
                    'start_time' => '09:00:00',
                    'end_time' => '18:00:00',
                    'grace_period_minutes' => 15,
                    'description' => 'Regular office hours 9 AM to 6 PM',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Evening Shift',
                    'start_time' => '14:00:00',
                    'end_time' => '23:00:00',
                    'grace_period_minutes' => 15,
                    'description' => 'Evening shift 2 PM to 11 PM',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Night Shift',
                    'start_time' => '22:00:00',
                    'end_time' => '07:00:00',
                    'grace_period_minutes' => 15,
                    'description' => 'Night shift 10 PM to 7 AM',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }

    public function down()
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->dropColumn(['name', 'start_time', 'end_time', 'grace_period_minutes', 'is_active', 'description']);
        });
    }
};
