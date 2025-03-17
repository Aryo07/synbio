@extends('backends.layouts.app', ['title' => 'Orders'])

@section('content')
<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header border-0 bg-primary text-white">
                    <h4 class="card-title m-0 font-weight-bold"><i class="bi bi-box-seam"></i> ORDERS</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.orders.index') }}">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="q" placeholder="Search data here...">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> SEARCH</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Table with outer spacing -->
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO.</th>
                                        <th>Bukti Pembayaran</th>
                                        <th>No. INOVICE</th>
                                        <th>CUSTOMER</th>
                                        <th>TOTAL BIAYA</th>
                                        <th>STATUS</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration + $orders->perPage() * ($orders->currentPage() - 1) }}</td>
                                        <td>
                                            @if ($order->payment->image)
                                                <a href="{{ asset('storage/payments/' . $order->payment->image) }}" target="_blank">{{ $order->payment->image }}</a>
                                            @else
                                                <p>Bukti Pembayaran Belum Tersedia</p>
                                            @endif
                                        </td>
                                        <td>{{ $order->invoice_number }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        {{-- <td>{{ optional($order->user)->name }}</td> --}}
                                        <td>{{ moneyFormat($order->total_price) }}</td>
                                        <td>
                                            @if ($order->status == 'PENDING')
                                                <span class="badge bg-warning">{{ $order->status }}</span>
                                            @elseif ($order->status == 'SUCCESS')
                                                <span class="badge bg-success">{{ $order->status }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $order->status }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($order->status == 'SUCCESS')
                                                <a href="{{ route('customers.invoice', ['orderId' => $order->id]) }}" class="btn btn-sm btn-primary" target="_blank">
                                                    <i class="bi bi-file-earmark-text"></i>
                                                </a>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <td colspan="5" class="text-center">Data Belum Tersedia!</td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 d-flex justify-content-between mt-3">
                            <div>
                                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} entries
                            </div>
                            <div>
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection