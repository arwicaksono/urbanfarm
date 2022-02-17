<?php

namespace Database\Seeders;

use App\Models\SalesChannel;
use Illuminate\Database\Seeder;

class SalesChannelTableSeeder extends Seeder
{
    public function run()
    {
        $salesChannel = [
            [
                'id'   => 1,
                'name' => 'kiosk',
            ],
            [
                'id'   => 2,
                'name' => 'traditional market',
            ],
            [
                'id'   => 3,
                'name' => 'reseller',
            ],
            [
                'id'   => 4,
                'name' => 'modern market',
            ],
            [
                'id'   => 5,
                'name' => 'social media',
            ],
            [
                'id'   => 6,
                'name' => 'website',
            ],
            [
                'id'   => 7,
                'name' => 'marketplace',
            ],
        ];

        SalesChannel::insert($salesChannel);
    }
}
