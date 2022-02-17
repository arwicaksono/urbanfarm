<?php

namespace Database\Seeders;

use App\Models\AttCategory;
use Illuminate\Database\Seeder;

class AttCategoryTableSeeder extends Seeder
{
    public function run()
    {
        $attCategory = [
            [
                'id'   => 1,
                'name' => 'vegetables',
            ],
            [
                'id'   => 2,
                'name' => 'herbs',
            ],
            [
                'id'   => 3,
                'name' => 'roots',
            ],
            [
                'id'   => 4,
                'name' => 'fruits',
            ],
            [
                'id'   => 5,
                'name' => 'ornamentals',
            ],
        ];

        AttCategory::insert($attCategory);
    }
}
