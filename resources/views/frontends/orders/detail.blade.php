@extends('frontends.layouts.app', ['title' => 'Orders Detail'])

@section('content')
    <section id="order">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3>Checkout</h3>
                </div>
            </div>

            <form method="POST" action="{{ route('orders.update', $order->id) }}" id="order-form">
                @csrf
                @method('PUT')
                <div class="row mt-3">
                    <div class="col-lg-6">
                        @foreach ($order->orderItems as $item)
                            <div class="row">
                                <div class="col">
                                    <div class="card mb-3">
                                        <div class="row g-0">
                                            <div class="col-md-4 foto-produk">
                                                <img src="{{ asset('storage/products/' . $item->product->image) }}"
                                                    class="img-fluid rounded-start" alt="{{ $item->product->slug }}">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $item->product->title }}</h5>
                                                    <div class="row mt-5">
                                                        <div class="col-lg-4">
                                                            <label for="jumlah" class="form-label">Jumlah</label>
                                                            <div class="d-flex">
                                                                <input type="number" class="form-control me-2"
                                                                    value="{{ $item->weight }}" disabled>
                                                                <h6>kg</h6>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-8 text-end">
                                                            <h4>Total : {{ moneyFormat($item->price) }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-lg-6">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="shipping_address" class="form-label">Alamat</label>
                                <textarea name="shipping_address" id="shipping_address"
                                    class="form-control @error('shipping_address') is-invalid @enderror"
                                    placeholder="silahkan isi alamat lengkap & detail" rows="3">{{ $order->shipping_address }}</textarea>

                                @error('shipping_address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="metod-kirim" class="form-label">Metode Pengiriman</label>
                                <select class="form-select @error('courier_id') is-invalid @enderror" name="courier_id"
                                    id="courier_id" aria-label="metod-kirim">
                                    <option selected disabled>-- Pilih Satu --</option>
                                    @foreach ($couriers as $courier)
                                        <option value="{{ $courier->id }}" data-cost="{{ $courier->cost }}"
                                            {{ $order->courier_id == $courier->id ? 'selected' : '' }}>
                                            {{ $courier->name }} - {{ moneyFormat($courier->cost) }}</option>
                                    @endforeach
                                </select>

                                @error('courier_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <label for="metod-bayar" class="form-label">Metode Pembayaran</label>
                                <select class="form-select @error('bank_id') is-invalid @enderror" name="bank_id"
                                    id="bank_id" aria-label="metod-bayar">
                                    <option selected disabled>-- Pilih Satu --</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}"
                                            {{ $order->bank_id == $bank->id ? 'selected' : '' }}>
                                            {{ $bank->bank_name }} - {{ $bank->account_number }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('bank_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <h4>Rincian Pembayaran</h4>
                                @php
                                    $totalHargaProduk = $order->orderItems->sum('price');
                                @endphp
                                <h6>Total Harga Produk :
                                    <span id="total-harga-produk">{{ moneyFormat($totalHargaProduk) }}</span>
                                </h6>
                                <h6>Ongkos Kirim :
                                    <span id="ongkos-kirim">{{ moneyFormat($order->shipping_cost) }}</span>
                                </h6>
                                <hr>
                                <h6>Total Belanja :
                                    <span
                                        id="total-belanja">{{ moneyFormat($order->total_price + $order->shipping_cost) }}</span>
                                </h6>
                                <button type="button" class="btn btn-success w-100 mt-3" data-bs-toggle="modal"data-bs-target="#confirmModal">
                                    Lanjut Bayar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Modal -->
            <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="confirmModalLabel">Konfirmasi Pembayaran</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin ingin melanjutkan pembayaran?
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('products.page') }}" class="btn btn-secondary">Lanjut Belanja</a>
                            <button type="button" class="btn btn-success" id="confirmPayment">Bayar Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.getElementById('confirmPayment').addEventListener('click', function() {
                    document.getElementById('order-form').submit();
                });
            </script>
        </div>
    </section>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#courier_id').change(function() {
                var cost = $(this).find(':selected').data('cost');
                var totalHargaProduk = $('#total-harga-produk').text().replace('Rp', '').replace(/\./g, '');
                var ongkosKirim = cost;
                var totalBelanja = parseInt(totalHargaProduk) + parseInt(ongkosKirim);

                $('#ongkos-kirim').text('Rp' + ongkosKirim.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'));
                $('#total-belanja').text('Rp' + totalBelanja.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'));
            });
        });
    </script>
@endpush