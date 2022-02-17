<?php

namespace Database\Seeders;

use App\Models\PurchaseEquipment;
use Illuminate\Database\Seeder;

class PurchaseEquipmentTableSeeder extends Seeder
{
    public function run()
    {
        $purchaseEquipment = [
            [
                'id'   => 1,
                'name' => 'Gully',
            ],
            [
                'id'   => 2,
                'name' => 'Pompa',
            ],
            [
                'id'   => 3,
                'name' => 'Meja',
            ],
            [
                'id'   => 4,
                'name' => 'Netpot',
            ],
            [
                'id'   => 5,
                'name' => 'Selang',
            ],
        ];

        PurchaseEquipment::insert($purchaseEquipment);
    }
}
