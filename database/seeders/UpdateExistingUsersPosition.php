<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateExistingUsersPosition extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Update existing users based on their role
        $users = User::all();
        
        foreach ($users as $user) {
            if ($user->role == 1 && !$user->position) {
                $user->update(['position' => 'Admin']);
            } elseif ($user->role == 2 && !$user->position) {
                $user->update(['position' => 'Employee']);
            } elseif ($user->role == 4 && !$user->position) {
                $user->update(['position' => 'Manager']);
            }
        }
        
        echo "Updated positions for existing users based on their roles.\n";
    }
}
