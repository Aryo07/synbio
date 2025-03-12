<?php

namespace App\Http\Controllers\Frontends;

use App\Models\Bank;
use App\Models\Order;
use App\Models\Courier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->get();
        // Define the $order variable
        $order = $orders->first();

        // Update total price order
        if ($order) {
            $order->total_price = $order->orderItems->sum('price');
            $order->save();
        }
        return view('frontends.orders.index', compact('orders'));
    }

    public function show($orderId)
    {
        // $couriers = Courier::all();
        // $banks = Bank::all();
        // $order = Order::with('orderItems')->findOrFail($orderId);
        // return view('frontends.orders.detail', compact('order', 'couriers', 'banks'));

        // Mengambil data order berdasarkan id dan user_id yang sedang login
        $order = Order::with('orderItems')->where('id', $orderId)->where('user_id', Auth::user()->id)->first();

        // Cek apakah order ada atau tidak ditemukan berdasarkan id dan user_id yang sedang login
        if (!$order) {
            return view('frontends.errors.404');
        }

        // Cek apakah status order sudah success maka tidak bisa diakses lagi ke halaman detail order tersebut melalui URL browser
        if ($order->status == 'SUCCESS') {
            return view('frontends.errors.404');
        }

        $couriers = Courier::all();
        $banks = Bank::all();
        return view('frontends.orders.detail', compact('order', 'couriers', 'banks'));
    }

    public function update(Request $request, $orderId)
    {
        $request->validate(
            [
                'courier_id' => 'required|exists:couriers,id',
                'bank_id' => 'required|exists:banks,id',
                'shipping_address' => 'required',
            ],
            [
                'courier_id.required' => 'Pilih kurir pengiriman!',
                'courier_id.exists' => 'Kurir pengiriman tidak valid!',
                'bank_id.required' => 'Pilih metode pembayaran!',
                'bank_id.exists' => 'Metode pembayaran tidak valid!',
                'shipping_address.required' => 'Alamat pengiriman tidak boleh kosong!',
            ]
        );

        $order = Order::findOrFail($orderId);
        $courier = Courier::findOrFail($request->courier_id);

        // Hitung total_price dari order yang ditambahkan dengan biaya pengiriman cost dari courier yang dipilih
        $shippingCost = $courier->cost;

        // Membuat random invoice number
        $length = 10;
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
        }
        $no_invoice = 'INV-' . Str::upper($random);

        $order->update([
            'courier_id' => $request->courier_id,
            'bank_id' => $request->bank_id,
            'shipping_address' => $request->shipping_address,
            'shipping_cost' => $shippingCost,
            'invoice_number' => $no_invoice,
            'status' => 'PENDING',
        ]);

        // Hapus semua cart user yang sedang login setelah order berhasil dibuat dan lanjut ke proses pembayaran
        Cart::where('user_id', Auth::user()->id)->delete();

        toastr()
            ->positionClass('toast-top-center')
            ->success('Pesanan berhasil dibuat, silahkan lanjutkan ke proses pembayaran!');
        return redirect()->route('payment.process', $order->id);
    }
}
