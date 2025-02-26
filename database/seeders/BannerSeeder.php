<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Banner 1',
                'slug' => 'banner-1',
                'subtitle' => 'Subtitle 1',
                'description' => 'Description 1',
                'image' => 'banner1.jpg',
                'position' => 1,
                'status' => 'show',
            ],
            [
                'title' => 'Banner 2',
                'slug' => 'banner-2',
                'subtitle' => 'Subtitle 2',
                'description' => 'Description 2',
                'image' => 'banner2.jpg',
                'position' => 2,
                'status' => 'hide',
            ],
            [
                'title' => 'Banner 3',
                'slug' => 'banner-3',
                'subtitle' => 'Subtitle 3',
                'description' => 'Description 3',
                'image' => 'banner3.jpg',
                'position' => 1,
                'status' => 'show',
            ],
            [
                'title' => 'Banner 4',
                'slug' => 'banner-4',
                'subtitle' => 'Subtitle 4',
                'description' => 'Description 4',
                'image' => 'banner4.jpg',
                'position' => 2,
                'status' => 'hide',
            ],
            [
                'title' => 'Banner 5',
                'slug' => 'banner-5',
                'subtitle' => 'Subtitle 5',
                'description' => 'Description 5',
                'image' => 'banner5.jpg',
                'position' => 1,
                'status' => 'show',
            ],
        ];

        foreach ($banners as $key =>$value) {
            Banner::create($value);
        }
    }
}
