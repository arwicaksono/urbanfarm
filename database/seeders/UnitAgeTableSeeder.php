<?php

namespace Database\Seeders;

use App\Models\UnitAge;
use Illuminate\Database\Seeder;

class UnitAgeTableSeeder extends Seeder
{
    public function run()
    {
        $unitAge = [
            [
                'id'   => 1,
                'name' => 'dfss/hss',
            ],
            [
                'id'   => 2,
                'name' => 'dft/hss',
            ],
        ];

        UnitAge::insert($unitAge);
    }
}
