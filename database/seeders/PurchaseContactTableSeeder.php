<?php

namespace Database\Seeders;

use App\Models\PurchaseContact;
use Illuminate\Database\Seeder;

class PurchaseContactTableSeeder extends Seeder
{
    public function run()
    {
        $purchaseContact = [
            [
                'id'   => 1,
                'name' => 'Ir Bejo Terus, MBA',
            ],
            [
                'id'   => 2,
                'name' => 'Dra Sissy Similikithi',
            ],
            [
                'id'   => 3,
                'name' => 'Paijo Merto Segoro, PhD',
            ],
            [
                'id'   => 4,
                'name' => 'Hj Nona Noni',
            ],
            [
                'id'   => 5,
                'name' => 'H. Alim Banget, SH',
            ],
        ];

        PurchaseContact::insert($purchaseContact);
    }
}
