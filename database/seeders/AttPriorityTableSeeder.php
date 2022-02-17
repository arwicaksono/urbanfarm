<?php

namespace Database\Seeders;

use App\Models\AttPriority;
use Illuminate\Database\Seeder;

class AttPriorityTableSeeder extends Seeder
{
    public function run()
    {
        $attPriority = [
            [
                'id'   => 1,
                'name' => 'routine',
            ],
            [
                'id'   => 2,
                'name' => 'important',
            ],
            [
                'id'   => 3,
                'name' => 'urgent',
            ],
            [
                'id'   => 4,
                'name' => 'critical',
            ],
            [
                'id'   => 5,
                'name' => 'emergency',
            ],
        ];

        AttPriority::insert($attPriority);
    }
}
