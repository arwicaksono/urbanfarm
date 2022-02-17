<?php

namespace Database\Seeders;

use App\Models\SalesMarket;
use Illuminate\Database\Seeder;

class SalesMarketTableSeeder extends Seeder
{
    public function run()
    {
        $salesMarket = [
            [
                'id'   => 1,
                'name' => 'individual',
            ],
            [
                'id'   => 2,
                'name' => 'company',
            ],
            [
                'id'   => 3,
                'name' => 'event',
            ],
            [
                'id'   => 4,
                'name' => 'school',
            ],
            [
                'id'   => 5,
                'name' => 'restaurant',
            ],
            [
                'id'   => 6,
                'name' => 'cafe',
            ],
        ];

        SalesMarket::insert($salesMarket);
    }
}
