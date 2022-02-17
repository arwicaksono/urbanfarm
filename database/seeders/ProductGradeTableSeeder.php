<?php

namespace Database\Seeders;

use App\Models\ProductGrade;
use Illuminate\Database\Seeder;

class ProductGradeTableSeeder extends Seeder
{
    public function run()
    {
        $grade = [
            [
                'id'   => 1,
                'name' => 'A',
            ],
            [
                'id'   => 2,
                'name' => 'B',
            ],
            [
                'id'   => 3,
                'name' => 'C',
            ],
            [
                'id'   => 4,
                'name' => 'D',
            ],
            [
                'id'   => 5,
                'name' => 'F',
            ],
        ];

        ProductGrade::insert($grade);
    }
}
