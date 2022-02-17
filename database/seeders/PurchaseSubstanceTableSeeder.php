<?php

namespace Database\Seeders;

use App\Models\PurchaseSubstance;
use Illuminate\Database\Seeder;

class PurchaseSubstanceTableSeeder extends Seeder
{
    public function run()
    {
        $purchaseSubstance = [
            [
                'id'   => 1,
                'name' => 'Antracol',
            ],
            [
                'id'   => 2,
                'name' => 'AB-Mix',
            ],
            [
                'id'   => 3,
                'name' => 'QuikGrow',
            ],
            [
                'id'   => 4,
                'name' => 'Roundup',
            ],
            [
                'id'   => 5,
                'name' => 'Maxigrow',
            ],
        ];

        PurchaseSubstance::insert($purchaseSubstance);
    }
}
