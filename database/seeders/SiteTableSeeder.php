<?php

namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Database\Seeder;

class SiteTableSeeder extends Seeder
{
    public function run()
    {
        $site = [
            [
                'id'        => 1,
                'code'      => 'SITE-1',
                'number'    => 1,
                'name'      => 'Kebun',
                'location'  => 'Jl Magelang km 18',
                'acreage'   => 100,
                'note'      => 'good luck',
            ],
            [
                'id'        => 2,
                'code'      => 'SITE-2',
                'number'    => 2,
                'name'      => 'Sawah',
                'location'  => 'Lojajar',
                'acreage'   => 200,
                'note'      => 'good luck',
            ],
            [
                'id'        => 3,
                'code'      => 'SITE-3',
                'number'    => 3,
                'name'      => 'Sawah 2',
                'location'  => 'Molodono',
                'acreage'   => 400,
                'note'      => 'good luck',
            ],
            [
                'id'        => 4,
                'code'      => 'SITE-4',
                'number'    => 4,
                'name'      => 'Bibis 1',
                'location'  => 'Jl Magelang km 18',
                'acreage'   => 100,
                'note'      => 'good luck',
            ],
            [
                'id'        => 5,
                'code'      => 'SITE-5',
                'number'    => 5,
                'name'      => 'Bibis 2',
                'location'  => 'Jl Magelang km 18',
                'acreage'   => 100,
                'note'      => 'good luck',
            ],
        ];

        Site::insert($site);
    }
}
