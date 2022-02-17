<?php

namespace Database\Seeders;

use App\Models\SiteWaterSource;
use Illuminate\Database\Seeder;

class SiteWaterSourceTableSeeder extends Seeder
{
    public function run()
    {
        $siteWaterSource = [
            [
                'id'   => 1,
                'name' => 'well',
            ],
            [
                'id'   => 2,
                'name' => 'tap water',
            ],
            [
                'id'   => 3,
                'name' => 'rainwater',
            ],
            [
                'id'   => 4,
                'name' => 'river',
            ],
            [
                'id'   => 5,
                'name' => 'pond',
            ],
            [
                'id'   => 6,
                'name' => 'reverse osmosis',
            ],
        ];

        SiteWaterSource::insert($siteWaterSource);
    }
}
