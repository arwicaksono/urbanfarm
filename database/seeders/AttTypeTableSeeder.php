<?php

namespace Database\Seeders;

use App\Models\AttType;
use Illuminate\Database\Seeder;

class AttTypeTableSeeder extends Seeder
{
    public function run()
    {
        $attType = [
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

        AttType::insert($attType);
    }
}
