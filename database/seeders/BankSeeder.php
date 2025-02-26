<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            [
                'bank_name' => 'Bank BCA',
                'account_name' => 'PT. BCA',
                'account_number' => '1234567890',
                'image' => 'bca.png',
            ],
            [
                'bank_name' => 'Bank BNI',
                'account_name' => 'PT. BNI',
                'account_number' => '1234567890',
                'image' => 'bni.png',
            ],
            [
                'bank_name' => 'Bank BRI',
                'account_name' => 'PT. BRI',
                'account_number' => '1234567890',
                'image' => 'bri.png',
            ],
            [
                'bank_name' => 'Bank Mandiri',
                'account_name' => 'PT. Mandiri',
                'account_number' => '1234567890',
                'image' => 'mandiri.png',
            ],
        ];

        foreach ($banks as $bank) {
            Bank::create($bank);
        }
    }
}
