<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staprio;

class StaprioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default Statuses
        $statuses = [
            [
                'name' => 'Hot',
                'value' => 'hot',
                'type' => 'status',
                'color' => '#dc3545',
                'is_protected' => false,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Cold',
                'value' => 'cold',
                'type' => 'status',
                'color' => '#0dcaf0',
                'is_protected' => false,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Warm',
                'value' => 'warm',
                'type' => 'status',
                'color' => '#ffc107',
                'is_protected' => false,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Qualified',
                'value' => 'qualified',
                'type' => 'status',
                'color' => '#198754',
                'is_protected' => true, // This is protected as requested
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Lost',
                'value' => 'lost',
                'type' => 'status',
                'color' => '#6c757d',
                'is_protected' => false,
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        // Default Priorities
        $priorities = [
            [
                'name' => 'High',
                'value' => 'high',
                'type' => 'priority',
                'color' => '#dc3545',
                'is_protected' => false,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Medium',
                'value' => 'medium',
                'type' => 'priority',
                'color' => '#ffc107',
                'is_protected' => false,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Low',
                'value' => 'low',
                'type' => 'priority',
                'color' => '#0dcaf0',
                'is_protected' => false,
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        // Insert statuses
        foreach ($statuses as $status) {
            Staprio::updateOrCreate(
                ['type' => 'status', 'value' => $status['value']],
                $status
            );
        }

        // Insert priorities
        foreach ($priorities as $priority) {
            Staprio::updateOrCreate(
                ['type' => 'priority', 'value' => $priority['value']],
                $priority
            );
        }

        $this->command->info('Staprio table seeded with default statuses and priorities.');
    }
}
