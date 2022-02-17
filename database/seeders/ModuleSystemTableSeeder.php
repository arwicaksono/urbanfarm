<?php

namespace Database\Seeders;

use App\Models\ModuleSystem;
use Illuminate\Database\Seeder;

class ModuleSystemTableSeeder extends Seeder
{
    public function run()
    {
        $moduleSystem = [
            [
                'id'   => 1,
                'name' => 'nutrient film technique',
            ],
            [
                'id'   => 2,
                'name' => 'deep water culture',
            ],
            [
                'id'   => 3,
                'name' => 'ebb & flow',
            ],
            [
                'id'   => 4,
                'name' => 'wick',
            ],
            [
                'id'   => 5,
                'name' => 'drip system',
            ],
            [
                'id'   => 6,
                'name' => 'raft',
            ],
            [
                'id'   => 7,
                'name' => 'aeroponic',
            ],
            [
                'id'   => 8,
                'name' => 'aquaponic',
            ],
        ];

        ModuleSystem::insert($moduleSystem);
    }
}
