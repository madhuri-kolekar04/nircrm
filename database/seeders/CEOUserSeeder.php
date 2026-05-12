<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CEOUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create or update CEO user
        User::updateOrCreate(
            ['email' => 'ceo@niranjancrm.com'],
            [
                'name' => 'CEO',
                'email' => 'ceo@niranjancrm.com',
                'password' => Hash::make('123456789'),
                'role' => 5, // CEO role number
                'position' => 'CEO',
                'department' => 'Executive',
                'employeeID' => 'CEO001',
                'contact_number' => '9999999999',
            ]
        );
    }
}
