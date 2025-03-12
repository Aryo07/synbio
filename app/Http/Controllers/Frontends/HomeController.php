<?php

namespace App\Http\Controllers\Frontends;

use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home()
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

        // tampilkan product yang paling banyak di order berdasarkan product_id, order_id pada table order_items
        $productsOrders = Product::select('products.*')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderByRaw('SUM(order_items.weight) DESC')
            // ->orderByRaw('COUNT(order_items.product_id) DESC')
            ->limit(4)
            ->get();

        return view('frontends.home', compact('banners', 'products', 'productsOrders'));

        // dd($banners, $products, $productsOrder);
    }
}
