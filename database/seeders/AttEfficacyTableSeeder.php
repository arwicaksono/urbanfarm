<?php

namespace Database\Seeders;

use App\Models\AttEfficacy;
use Illuminate\Database\Seeder;

class AttEfficacyTableSeeder extends Seeder
{
    public function run()
    {
        $efficacy = [
            [
                'id'   => 1,
                'name' => 'effective',
            ],
            [
                'id'   => 2,
                'name' => 'less effective',
            ],
            [
                'id'   => 3,
                'name' => 'no effect',
            ],
        ];

        AttEfficacy::insert($efficacy);
    }
}
