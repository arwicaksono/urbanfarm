<?php

namespace Database\Seeders;

use App\Models\UnitQuantity;
use Illuminate\Database\Seeder;

class UnitQuantityTableSeeder extends Seeder
{
    public function run()
    {
        $unitQuantity = [
            [
                'id'   => 1,
                'name' => 'seeds',
            ],
            [
                'id'   => 2,
                'name' => 'pieces',
            ],
            [
                'id'   => 3,
                'name' => 'packs',
            ],
            [
                'id'   => 4,
                'name' => 'bags',
            ],
            [
                'id'   => 5,
                'name' => 'holes',
            ],
            [
                'id'   => 6,
                'name' => 'pots',
            ],
            [
                'id'   => 7,
                'name' => 'pail',
            ],
        ];

        UnitQuantity::insert($unitQuantity);
    }
}
