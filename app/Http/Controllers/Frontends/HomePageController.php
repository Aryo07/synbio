<?php

namespace App\Http\Controllers\Frontends;

use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    public function index()
    {
        // Menampilkan banner dengan status show dan position banner 1 dan 2 serta melimit banner di posisi 1 dan 2 hanya menampilkan 1 banner per posisi
        $banners = Banner::where('status', 'show')
            ->whereIn('position', [1, 2])
            ->orderBy('id', 'desc')
            ->get()
            ->groupBy('position')
            ->map(function ($group) {
                return $group->first();
            });

        // Menampilkan produk dengan status show dan diurutkan berdasarkan id secara descending
        $products = Product::where('status', 'show')
        ->orderBy('id', 'desc')
        ->limit(4)
        ->get();

        return view('frontends.home', compact('banners', 'products'));

        // dd($banners, $products);
    }
}
