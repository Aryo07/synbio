@extends('frontends.layouts.app', ['title' => 'Orders'])

@section('content')
<section id="order">
    <div class="container">
        <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Order</h4>
                            <p class="card-text">User: {{ Auth::user()->name }} | {{ Auth::user()->email }} | {{ Auth::user()->phone }}</p>
                        </div>
                    </div>
                    <div class="card-content">
                        @if ($orders->isEmpty())
                            <div class="card-body">
                                <p class="text-center">Tidak ada order</p>
                            </div>
                        @else
                            <!-- table hover -->
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Invoice</th>
                                            <th>Tanggal</th>
                                            <th>Total Harga</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr class="text-center">
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    @if ($order->invoice_number)
                                                        {{ $order->invoice_number }}
                                                    @else
                                                        <p>Nomor Invoice Belum Tersedia</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $order->created_at->format('d F Y') }}
                                                </td>
                                                <td>
                                                    @if ($order->status == 'PENDING' || $order->status == 'SUCCESS')
                                                        {{ moneyFormat($order->total_price + $order->shipping_cost) }}
                                                    @else
                                                        {{ moneyFormat($order->total_price) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($order->status == 'PENDING')
                                                        <span class="badge bg-warning">{{ $order->status }}</span>
                                                    @elseif ($order->status == 'SUCCESS')
                                                        <span class="badge bg-success">{{ $order->status }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($order->status == 'SUCCESS')
                                                        <a href="{{ route('invoice', ['orderId' => $order->id]) }}" class="btn btn-success btn-sm w-50" target="_blank">
                                                            <i class="fas fa-file-invoice"></i> Invoice
                                                        </a>
                                                    @elseif ($order->status == 'PENDING' && $order->payment && $order->payment->image == null)
                                                        <a href="{{ route('payment.index', $order->id) }}" class="btn btn-warning btn-sm w-50">
                                                            <i class="fas fa-credit-card"></i> Bayar
                                                        </a>
                                                    @elseif ($order->status == 'PENDING' && $order->payment && $order->payment->image != null)
                                                        <!-- Hidden button for 'Bayar' -->
                                                        -
                                                    @else
                                                        <a href="{{ route('orders.detail', ['orderId' => $order->id]) }}" class="btn btn-secondary btn-sm w-50">
                                                            <i class="fas fa-info-circle"></i> Checkout
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection