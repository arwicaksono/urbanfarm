<?php

namespace Database\Seeders;

use App\Models\SalesDelivery;
use Illuminate\Database\Seeder;

class SalesDeliveryTableSeeder extends Seeder
{
    public function run()
    {
        $salesDelivery = [
            [
                'id'   => 1,
                'name' => 'gojek',
            ],
            [
                'id'   => 2,
                'name' => 'grab',
            ],
            [
                'id'   => 3,
                'name' => 'jne',
            ],
            [
                'id'   => 4,
                'name' => 'pos',
            ],
            [
                'id'   => 5,
                'name' => 'rental',
            ],
            [
                'id'   => 6,
                'name' => 'own vehicle',
            ],
        ];

        SalesDelivery::insert($salesDelivery);
    }
}
