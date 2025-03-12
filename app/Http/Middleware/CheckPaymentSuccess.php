<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPaymentSuccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session('payment_success')) {
            return redirect()->route('home'); // Kembali ke halaman home jika tidak ada session flag payment_success
        }

        // Hapus session flag payment_success setelah di cek di atas agar tidak bisa diakses kembali
        session()->forget('payment_success');

        return $next($request);
    }
}
