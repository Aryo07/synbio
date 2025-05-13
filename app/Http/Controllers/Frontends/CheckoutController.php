<?php

namespace App\Http\Controllers\Frontends;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request)
    {
        // Ambil semua cart item user yang sedang login
        $carts = Cart::where('user_id', Auth::user()->id)->get();

        // Jika cart item kosong, redirect kembali ke halaman cart dengan pesan error
        if ($carts->isEmpty()) {
            toastr()
                ->error('Keranjang belanja masih kosong, silahkan tambahkan produk terlebih dahulu!');
            return redirect()->route('carts');
        }

        // Cek apakah user sudah memiliki order yang belum dibayar
        $order = Order::where('user_id', Auth::user()->id)->where('status', 'process')->first();

        if(!$order) {
            // Membuat order baru jika belum ada order yang di process
            $order = Order::create([
                'user_id' => Auth::user()->id,
                'total_price' => 0, // akan di update setelah order item di create
                'status' => 'process',
            ]);
        }

        // Membuat order item dari cart item
        foreach ($carts as $cart) {
            // Cek apakah product sudah ada di order item
            $existingOrderItem = OrderItem::where('order_id', $order->id)
                ->where('product_id', $cart->product_id)
                ->first();

            if (!$existingOrderItem) {
                // Buat order item baru jika product belum ada di order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'price' => $cart->price,
                    'weight' => $cart->product->weight * $cart->weight,
                ]);
            } else {
                // Update order item jika product sudah ada di order item
                $existingOrderItem->price = $cart->price;
                $existingOrderItem->weight = $cart->product->weight * $cart->weight;
                $existingOrderItem->save();
            }
        }

        // Hapus order item yang tidak ada di cart
        // $orderItems = OrderItem::where('order_id', $order->id)->get();
        // foreach ($orderItems as $orderItem) {
        //     if (!$carts->contains('product_id', $orderItem->product_id)) {
        //         $orderItem->delete();
        //     }
        // }

        // Update total price order
        $order->total_price = $order->orderItems->sum('price');
        $order->save();

        // Redirect ke halaman order dengan pesan sukses
        toastr()
            ->success('Berhasil checkout, silahkan lengkapi data pengiriman dan pembayaran!');
        // return redirect()->route('orders');
        return redirect()->route('orders.detail', ['orderId' => $order->id]);
    }
}
