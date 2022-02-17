<?php

namespace Database\Seeders;

use App\Models\Plot;
use Illuminate\Database\Seeder;

class PlotTableSeeder extends Seeder
{
    public function run()
    {
        $plot = [
            [
                'id'                    => 1,
                'code'                  => 'PLO-1',
                'number'                => 1,
                'note'                  => 'Note',
            ],
            [
                'id'                    => 2,
                'code'                  => 'PLO-2',
                'number'                => 2,
                'note'                  => 'Note',
            ],
            [
                'id'                    => 3,
                'code'                  => 'PLO-3',
                'number'                => 3,
                'note'                  => 'Note',
            ],
            [
                'id'                    => 4,
                'code'                  => 'PLO-4',
                'number'                => 4,
                'note'                  => 'Note',
            ],
            [
                'id'                    => 5,
                'code'                  => 'PLO-5',
                'number'                => 5,
                'note'                  => 'Note',
            ],
        ];
        Plot::insert($plot);
    }
}
