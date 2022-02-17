<?php

namespace Database\Seeders;

use App\Models\UnitWeight;
use Illuminate\Database\Seeder;

class UnitWeightTableSeeder extends Seeder
{
    public function run()
    {
        $unitWeight = [
            [
                'id'   => 1,
                'name' => 'gr',
            ],
            [
                'id'   => 2,
                'name' => 'ounce',
            ],
            [
                'id'   => 3,
                'name' => 'pound',
            ],
            [
                'id'   => 4,
                'name' => 'kg',
            ],
            [
                'id'   => 5,
                'name' => 'ton',
            ],
        ];

        UnitWeight::insert($unitWeight);
    }
}
