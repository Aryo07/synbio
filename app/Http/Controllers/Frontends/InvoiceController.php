<?php

namespace App\Http\Controllers\Frontends;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InvoiceController extends Controller
{
    public function index(Request $request, $orderId, $orientation = 'portrait') // dapat mengunkan $orientation 'portrait' atau 'landscape'
    {
        try {
            // ambil user yang sedang login
            $user = $request->user();

            // ambil data dari order yang sudah success berdasarkan id dan user yang sedang login dan guard admin yang sedang login
            if (Auth::guard('admin')->check()) {
                $order = Order::where('id', $orderId)
                    ->where('status', 'success')
                    ->firstOrFail();
            } else {
                $order = Order::where('id', $orderId)
                    ->where('status', 'success')
                    ->where('user_id', $user->id)
                    ->firstOrFail();
            }

            // generate PDF dengan orientation yang sudah ditentukan
            $pdf = Pdf::loadView('frontends.invoices.index', compact('order'))->setPaper('a4', $orientation);

            // tambahkan penomoran invoice sesuai dengan order yang success pada penamaan file
            $invoiceNumber = $order->invoice_number . '.pdf';

            // ini untuk download file PDF
            // return $pdf->download($invoiceNumber);

            // ini untuk menampilkan file PDF
            return $pdf->stream($invoiceNumber);
        } catch (ModelNotFoundException) {
            return response()->view('frontends.errors.404');
        }
    }
}
