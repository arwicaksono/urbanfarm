<?php

namespace Database\Seeders;

use App\Models\AttTag;
use Illuminate\Database\Seeder;

class AttTagTableSeeder extends Seeder
{
    public function run()
    {
        $attTag = [
            [
                'id'   => 1,
                'name' => 'lettuce',
            ],
            [
                'id'   => 2,
                'name' => 'tomato',
            ],
            [
                'id'   => 3,
                'name' => 'pepper',
            ],
            [
                'id'   => 4,
                'name' => 'microgreens',
            ],
            [
                'id'   => 5,
                'name' => 'herbs',
            ],
        ];

        AttTag::insert($attTag);
    }
}
