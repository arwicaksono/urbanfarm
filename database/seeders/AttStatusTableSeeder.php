<?php

namespace Database\Seeders;

use App\Models\AttStatus;
use Illuminate\Database\Seeder;

class AttStatusTableSeeder extends Seeder
{
    public function run()
    {
        $attStatus = [
            [
                'id'   => 1,
                'name' => 'success',
            ],
            [
                'id'   => 2,
                'name' => 'standard',
            ],
            [
                'id'   => 3,
                'name' => 'below standard',
            ],
            [
                'id'   => 4,
                'name' => 'failed',
            ],
        ];

        AttStatus::insert($attStatus);
    }
}
