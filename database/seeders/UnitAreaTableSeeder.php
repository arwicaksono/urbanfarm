<?php

namespace Database\Seeders;

use App\Models\UnitArea;
use Illuminate\Database\Seeder;

class UnitAreaTableSeeder extends Seeder
{
    public function run()
    {
        $unitArea = [
            [
                'id'   => 1,
                'name' => 'm2',
            ],
            [
                'id'   => 2,
                'name' => 'ha',
            ],
            [
                'id'   => 3,
                'name' => 'yard',
            ],
            [
                'id'   => 4,
                'name' => 'feet',
            ],
            [
                'id'   => 5,
                'name' => 'sqt',
            ],
            [
                'id'   => 6,
                'name' => 'acre',
            ],
        ];

        UnitArea::insert($unitArea);
    }
}
