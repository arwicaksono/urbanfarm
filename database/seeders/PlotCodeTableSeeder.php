<?php

namespace Database\Seeders;

use App\Models\PlotCode;
use Illuminate\Database\Seeder;

class PlotCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $plotCode = [
                [
                    'id'        => 1,
                    'prefix'    => 'ltc',
                    'plant'     => 'lettuce',
                ],
                [
                    'id'        => 2,
                    'prefix'    => 'clr',
                    'plant'     => 'cellery',
                ],
                [
                    'id'        => 3,
                    'prefix'    => 'spn',
                    'plant'     => 'spinach',
                ],
                [
                    'id'        => 4,
                    'prefix'    => 'wsp',
                    'plant'     => 'water spinach',
                ],
                [
                    'id'        => 5,
                    'prefix'    => 'kle',
                    'plant'     => 'kale',
                ],
                [
                    'id'        => 6,
                    'prefix'    => 'bpp',
                    'plant'     => 'bell pepper',
                ],
            ];

            PlotCode::insert($plotCode);
        }
    }
}
