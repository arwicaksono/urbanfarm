<?php

namespace Database\Seeders;

use App\Models\PurchaseCompany;
use Illuminate\Database\Seeder;

class PurchaseCompanyTableSeeder extends Seeder
{
    public function run()
    {
        $purchaseCompany = [
            [
                'id'   => 1,
                'name' => 'PT Maju Mapan Banget',
            ],
            [
                'id'   => 2,
                'name' => 'PT Biji Pasti Tumbuh',
            ],
            [
                'id'   => 3,
                'name' => 'PT Bibit Bobot Bebet',
            ],
            [
                'id'   => 4,
                'name' => 'CV Bibit Terbaik Lho',
            ],
            [
                'id'   => 5,
                'name' => 'CV Pabrik Bibit Top ',
            ],
            [
                'id'   => 6,
                'name' => 'PT Jos Sejahtera Sendiri',
            ],
        ];

        PurchaseCompany::insert($purchaseCompany);
    }
}
