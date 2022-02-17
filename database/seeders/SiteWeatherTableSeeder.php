<?php

namespace Database\Seeders;

use App\Models\SiteWeather;
use Illuminate\Database\Seeder;

class SiteWeatherTableSeeder extends Seeder
{
    public function run()
    {
        $siteWeather = [
            [
                'id'   => 1,
                'name' => 'sunny',
            ],
            [
                'id'   => 2,
                'name' => 'light cloud',
            ],
            [
                'id'   => 3,
                'name' => 'dark cloud',
            ],
            [
                'id'   => 4,
                'name' => 'light rain',
            ],
            [
                'id'   => 5,
                'name' => 'heavy rain',
            ],
            [
                'id'   => 6,
                'name' => 'storm',
            ],
        ];

        SiteWeather::insert($siteWeather);
    }
}
