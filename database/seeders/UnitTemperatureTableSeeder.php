<?php

namespace Database\Seeders;

use App\Models\UnitTemperature;
use Illuminate\Database\Seeder;

class UnitTemperatureTableSeeder extends Seeder
{
    public function run()
    {
        $unitTemperature = [
            [
                'id'   => 1,
                'name' => 'Celcius',
            ],
            [
                'id'   => 2,
                'name' => 'Fahrenheit',
            ],
        ];

        UnitTemperature::insert($unitTemperature);
    }
}
