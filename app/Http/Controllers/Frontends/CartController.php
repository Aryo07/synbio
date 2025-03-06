<?php

namespace App\Http\Controllers\Frontends;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class CartController extends Controller
{
    public function cart()
    {
        // Ambil data user yang sedang login saat ini
        $users = Auth::user()->id;
        // Ambil data cart berdasarkan user yang sedang login saat ini
        $carts = Cart::where('user_id', $users)->with('product')->get();

        // Definisikan jumlah minimal dan maksimal pembelian
        $min = 1;
        $max = 5;

        return view('frontends.carts.index', compact('carts', 'min', 'max'));
    }

    public function addCart(Request $request, $slug)
    {
        // Cari product berdasarkan slug
        $product = Product::where('slug', $slug)->firstOrFail();

        // Definisi jumlah minimal dan maksimal pembelian
        $min = 1;
        $max = 5;

        // Jumlah default pembelian adalah 1
        $weight = $request->input('weight', $min);

        // Cari keranjang berdasarkan user_id dan product_id
        $cart = Cart::where('user_id', Auth::user()->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            // Cek jika jumlah pembelian lebih dari 5 di detail product
            if ($cart->weight + $weight > $max) {
                toastr()
                    ->positionClass('toast-top-center')
                    ->error('Jumlah pembelian melebihi batas maksimal');
                return redirect()->route('products.detail', $product->slug);
            }
            $cart->weight += $weight;
            $cart->weight = $product->weight * $cart->weight;
            $cart->price = $product->price * $cart->weight;
            $cart->save();
        } else {
            // Cek jika jumlah pembelian lebih dari 5 di keranjang
            if ($weight > $max) {
                toastr()
                    ->positionClass('toast-top-center')
                    ->error('Jumlah pembelian melebihi batas maksimal');
                return redirect()->route('products.detail', $product->slug);
            }
            Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $product->id,
                'price' => $product->price * $weight,
                'weight' => $product->weight * $weight,
            ]);
        }

        toastr()
            ->positionClass('toast-top-center')
            ->success('Produk berhasil ditambahkan ke keranjang');
        return redirect()->route('products.detail', $product->slug);
    }

    public function cartCount()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->count();
        return response()->json(['count' => $carts]);
    }

    public function updateCart(Request $request, $id)
    {
        // Definisi jumlah minimal dan maksimal pembelian
        $min = 1;
        $max = 5;
        // Fungsi update keranjang belanja di halaman keranjang berdasarkan id keranjang
        $cart = Cart::where('user_id', Auth::user()->id)->where('id', $id)->firstOrFail();
        // Fungsi untuk default jumlah pembelian adalah 1 berdasarkan berat produk
        $weight = $request->input('weight', $min);

        if ($weight > $max) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jumlah pembelian melebihi batas maksimal',
            ], 400);
        }

        $cart->weight = $weight;
        $cart->weight = $cart->product->weight * $cart->weight;
        $cart->price = $cart->product->price * $cart->weight;
        $cart->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah jumlah pembelian',
            'cart' => $cart,
        ]);
    }

    public function deleteCart(Request $request, $id) 
    {
        // Fungsi hapus keranjang belanja di halaman keranjang berdasarkan id keranjang
        $cart = Cart::where('user_id', Auth::user()->id)->where('id', $id)->firstOrFail();
        $cart->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus produk dari keranjang',
        ]);
    }
}
