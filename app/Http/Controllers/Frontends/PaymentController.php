<?php

namespace App\Http\Controllers\Frontends;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index($paymentId)
    {
        // Cek apakah pembayaran sudah ada atau belum berdasarkan payment_id yang dipilih oleh user yang sedang login
        $payment = Payment::where('id', $paymentId)->where('user_id', Auth::user()->id)->firstOrFail();

        // Cek apakah gambar bukti pembayaran sudah diupload atau belum berdasarkan payment_id yang dipilih oleh user yang sedang login
        if ($payment->image !== null) {
            return view('frontends.errors.404');
        }

        return view('frontends.payments.index', compact('payment'));
    }

    public function processPayment($paymentId)
    {
        $order = Order::findOrFail($paymentId);

        // Cek apakah pembayaran sudah ada atau belum berdasarkan order_id yang dipilih
        $existingPayment = Payment::where('order_id', $order->id)->first();
        if ($existingPayment) {
            return redirect()->route('payment.index', $existingPayment->id);
        }

        // Buat data pembayaran baru berdasarkan order_id yang dipilih oleh user yang sedang login
        $payment = new Payment();
        $payment->user_id = Auth::user()->id;
        $payment->order_id = $order->id;
        $payment->image = null;
        $payment->save();

        return redirect()->route('payment.index', $payment->id);
    }

    public function confirmPayment(Request $request, $paymentId)
    {
        $request->validate(
            [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'image.required' => 'Gambar bukti pembayaran wajib diisi',
                'image.image' => 'File yang diupload harus berupa gambar',
                'image.mimes' => 'File yang diupload harus berupa gambar dengan format jpeg, png, jpg, gif, atau svg',
                'image.max' => 'Ukuran file yang diupload maksimal 2MB',
            ]
        );

        $payment = Payment::findOrFail($paymentId);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/payments'), $image_name);
            $payment->image = 'payments/' . $image_name;
            $payment->save();
        }

        // update status order menjadi success
        $order = Order::findOrFail($payment->order_id);
        $order->status = 'success';
        $order->save();

        toastr()
            ->positionClass('toast-top-center')
            ->success('Bukti pembayaran berhasil diupload');

        // Set session flag payment_success ke true
        session(['payment_success' => true]);

        return redirect()->route('payment.success');
    }
}
