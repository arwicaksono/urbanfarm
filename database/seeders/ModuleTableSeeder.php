<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleTableSeeder extends Seeder
{
    public function run()
    {
        $module = [
            [
                'id'                => 1,
                'code'              => 'MOD-1',
                'number'            => 1,
                'note'              => 'note',
            ],
            [
                'id'                => 2,
                'code'              => 'MOD-2',
                'number'            => 2,
                'note'              => 'note',
            ],
            [
                'id'                => 3,
                'code'              => 'MOD-3',
                'number'            => 3,
                'note'              => 'note',
            ],
            [
                'id'                => 4,
                'code'              => 'MOD-4',
                'number'            => 4,
                'note'              => 'note',
            ],
            [
                'id'                => 5,
                'code'              => 'MOD-5',
                'number'            => 5,
                'note'              => 'note',
            ],
        ];

        Module::insert($module);
    }
}
