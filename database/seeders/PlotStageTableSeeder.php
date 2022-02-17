<?php

namespace Database\Seeders;

use App\Models\PlotStage;
use Illuminate\Database\Seeder;

class PlotStageTableSeeder extends Seeder
{
    public function run()
    {
        $plotStage = [
            [
                'id'   => 1,
                'name' => 'germination',
            ],
            [
                'id'   => 2,
                'name' => 'juvenile',
            ],
            [
                'id'   => 3,
                'name' => 'growth',
            ],
            [
                'id'   => 4,
                'name' => 'pre-harvest',
            ],
            [
                'id'   => 5,
                'name' => 'finishing',
            ],
        ];

        PlotStage::insert($plotStage);
    }
}
