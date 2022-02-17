<?php

namespace Database\Seeders;

use App\Models\SalesLabel;
use Illuminate\Database\Seeder;

class SalesLabelTableSeeder extends Seeder
{
    public function run()
    {
        $salesLabel = [
            [
                'id'   => 1,
                'name' => 'red label',
            ],
            [
                'id'   => 2,
                'name' => 'green label',
            ],
            [
                'id'   => 3,
                'name' => 'blue label',
            ],
            [
                'id'   => 4,
                'name' => 'brown label',
            ],
        ];

        SalesLabel::insert($salesLabel);
    }
}
