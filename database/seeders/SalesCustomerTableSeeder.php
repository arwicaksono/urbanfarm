<?php

namespace Database\Seeders;

use App\Models\SalesCustomer;
use Illuminate\Database\Seeder;

class SalesCustomerTableSeeder extends Seeder
{
    public function run()
    {
        $salesCustomer = [
            [
                'id'   => 1,
                'name' => 'John Doe',
            ],
            [
                'id'   => 2,
                'name' => 'Michael Doe',
            ],
            [
                'id'   => 3,
                'name' => 'Caroline Doe',
            ],
            [
                'id'   => 4,
                'name' => 'Meta Doe',
            ],
            [
                'id'   => 5,
                'name' => 'Kirk Doe',
            ],
            [
                'id'   => 6,
                'name' => 'Men Doe',
            ],
        ];

        SalesCustomer::insert($salesCustomer);
    }
}
