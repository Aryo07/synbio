<?php

namespace Database\Seeders;

use App\Models\Courier;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $couriers = [
            [
                'name' => 'JNE',
                'service' => 'YES',
                'cost' => 10000,
            ],
            [
                'name' => 'JNE',
                'service' => 'REG',
                'cost' => 9000,
            ],
            [
                'name' => 'JNE',
                'service' => 'OKE',
                'cost' => 8000,
            ],
            [
                'name' => 'J&T',
                'service' => 'YES',
                'cost' => 11000,
            ],
            [
                'name' => 'J&T',
                'service' => 'REG',
                'cost' => 10000,
            ],
            [
                'name' => 'J&T',
                'service' => 'OKE',
                'cost' => 9000,
            ],
            [
                'name' => 'POS Indonesia',
                'service' => 'YES',
                'cost' => 12000,
            ],
            [
                'name' => 'POS Indonesia',
                'service' => 'REG',
                'cost' => 11000,
            ],
            [
                'name' => 'POS Indonesia',
                'service' => 'OKE',
                'cost' => 10000,
            ],
        ];

        foreach ($couriers as $courier) {
            Courier::create($courier);
        }
    }
}
