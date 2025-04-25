<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderPageController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $orders = Order::with('user', 'bank', 'courier')
            ->when(request()->q, function ($orders) use ($q) {
                $orders->where('invoice_number', 'like', "%$q%")
                    ->orWhere('total_price', 'like', "%$q%")
                    ->orWhereHas('user', function ($user) use ($q) {
                        $user->where('name', 'like', "%$q%");
                    });
            })->orderBy('id', 'desc')->paginate(10);
        return view('backends.orders.index', compact('orders'));
    }

    // merubah status order menjadi success
    public function create($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = 'success';
        $order->save();

        toastr()
            ->positionClass('toast-top-center')
            ->success('Order berhasil diubah menjadi success');
        return redirect()->route('admin.orders.index');
    }
}
