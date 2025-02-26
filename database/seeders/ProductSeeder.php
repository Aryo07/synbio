<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'title' => 'Product 1',
                'slug' => 'product-1',
                'description' => 'Description 1',
                'image' => 'product1.jpg',
                'weight' => 1000, // 1000 gram = 1 kg
                'price' => 10000,
                'status' => 'show',
            ],
            [
                'title' => 'Product 2',
                'slug' => 'product-2',
                'description' => 'Description 2',
                'image' => 'product2.jpg',
                'weight' => 2000, // 2000 gram = 2 kg
                'price' => 20000,
                'status' => 'show',
            ],
            [
                'title' => 'Product 3',
                'slug' => 'product-3',
                'description' => 'Description 3',
                'image' => 'product3.jpg',
                'weight' => 3000, // 3000 gram = 3 kg
                'price' => 30000,
                'status' => 'show',
            ],
            [
                'title' => 'Product 4',
                'slug' => 'product-4',
                'description' => 'Description 4',
                'image' => 'product4.jpg',
                'weight' => 4000, // 4000 gram = 4 kg
                'price' => 40000,
                'status' => 'show',
            ],
            [
                'title' => 'Product 5',
                'slug' => 'product-5',
                'description' => 'Description 5',
                'image' => 'product5.jpg',
                'weight' => 5000, // 5000 gram = 5 kg
                'price' => 50000,
                'status' => 'show',
            ],
        ];

        foreach ($products as $key => $value) {
            Product::create($value);
        }
    }
}
