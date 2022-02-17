<?php

namespace Database\Seeders;

use App\Models\ModuleActivity;
use Illuminate\Database\Seeder;

class ModuleActivityTableSeeder extends Seeder
{
    public function run()
    {
        $moduleActivity = [
            [
                'id'   => 1,
                'name' => 'germination',
            ],
            [
                'id'   => 2,
                'name' => 'nursery',
            ],
            [
                'id'   => 3,
                'name' => 'pre-harvest',
            ],
        ];

        ModuleActivity::insert($moduleActivity);
    }
}
