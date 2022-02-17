<?php

namespace Database\Seeders;

use App\Models\PurchaseBrand;
use Illuminate\Database\Seeder;

class PurchaseBrandTableSeeder extends Seeder
{
    public function run()
    {
        $purchaseBrand = [
            [
                'id'   => 1,
                'name' => 'inthanon',
            ],
            [
                'id'   => 2,
                'name' => 'rangipo',
            ],
            [
                'id'   => 3,
                'name' => 'rock',
            ],
            [
                'id'   => 4,
                'name' => 'panah merah',
            ],
            [
                'id'   => 5,
                'name' => 'bisi',
            ],
            [
                'id'   => 6,
                'name' => 'dara f1',
            ],
        ];

        PurchaseBrand::insert($purchaseBrand);
    }
}
