<?php

namespace Database\Seeders;

use App\Models\AttCategoryComp;
use Illuminate\Database\Seeder;

class AttCategoryCompTableSeeder extends Seeder
{
    public function run()
    {
        $attCategoryComp = [
            [
                'id'   => 1,
                'name' => 'pump',
            ],
            [
                'id'   => 2,
                'name' => 'lighting',
            ],
            [
                'id'   => 3,
                'name' => 'reservoir',
            ],
            [
                'id'   => 4,
                'name' => 'mounting',
            ],
            [
                'id'   => 5,
                'name' => 'others',
            ],
        ];

        AttCategoryComp::insert($attCategoryComp);
    }
}
