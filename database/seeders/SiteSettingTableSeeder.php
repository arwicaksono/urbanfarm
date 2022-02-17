<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingTableSeeder extends Seeder
{
    public function run()
    {
        $siteSetting = [
            [
                'id'   => 1,
                'name' => 'indoor',
            ],
            [
                'id'   => 2,
                'name' => 'outdoor',
            ],
            [
                'id'   => 3,
                'name' => 'greenhouse',
            ],
        ];

        SiteSetting::insert($siteSetting);
    }
}
