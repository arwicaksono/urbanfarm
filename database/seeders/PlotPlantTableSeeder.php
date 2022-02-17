<?php

namespace Database\Seeders;

use App\Models\PlotPlant;
use Illuminate\Database\Seeder;

class PlotPlantTableSeeder extends Seeder
{
    public function run()
    {
        $plotPlant = [
            [
                'id'        => 1,
                'name'      => 'lettuce',
            ],
            [
                'id'        => 2,
                'name'      => 'spinach',
            ],
            [
                'id'        => 3,
                'name'      => 'pepper',
            ],
            [
                'id'        => 4,
                'name'      => 'strawberry',
            ],
            [
                'id'        => 5,
                'name'      => 'cellery',
            ],
        ];

        PlotPlant::insert($plotPlant);
    }
}
