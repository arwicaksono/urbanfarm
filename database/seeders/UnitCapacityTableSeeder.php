<?php

namespace Database\Seeders;

use App\Models\UnitCapacity;
use Illuminate\Database\Seeder;

class UnitCapacityTableSeeder extends Seeder
{
    public function run()
    {
        $unitCapacity = [
            [
                'id'   => 1,
                'name' => 'cc',
            ],
            [
                'id'   => 2,
                'name' => 'litre',
            ],
            [
                'id'   => 3,
                'name' => 'gallon',
            ],
            [
                'id'   => 4,
                'name' => 'pail',
            ],
            [
                'id'   => 5,
                'name' => 'tank',
            ],
        ];

        UnitCapacity::insert($unitCapacity);
    }
}
