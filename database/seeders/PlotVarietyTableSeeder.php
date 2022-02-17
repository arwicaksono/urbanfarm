<?php

namespace Database\Seeders;

use App\Models\PlotVariety;
use Illuminate\Database\Seeder;

class PlotVarietyTableSeeder extends Seeder
{
    public function run()
    {
        $plotVariety = [
            [
                'id'        => 1,
                'name'      => 'romaine',
            ],
            [
                'id'        => 2,
                'name'      => 'pagoda',
            ],
            [
                'id'        => 3,
                'name'      => 'red spinach',
            ],
            [
                'id'        => 4,
                'name'      => 'kale',
            ],

        ];

        PlotVariety::insert($plotVariety);
    }
}
