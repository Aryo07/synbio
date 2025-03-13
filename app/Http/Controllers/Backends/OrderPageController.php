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
                    ->orWhereHas('user', function ($user) use ($q){
                        $user->where('name', 'like', "%$q%");
                    });
            })->orderBy('id', 'desc')->paginate(10);
        return view('backends.orders.index', compact('orders'));
    }
}
