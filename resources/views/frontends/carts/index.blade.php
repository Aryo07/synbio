@extends('frontends.layouts.app', ['title' => 'Cart'])

@section('content')
    <section id="keranjang">
        <div class="container">
            @if ($carts->isEmpty())
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('frontends/assets/empty-cart.png') }}" class="img-fluid" alt="cart">
                </div>
            @else
                <div class="row">
                    <div class="col">
                        <h3>Keranjang</h3>
                    </div>
                </div>
                <form action="#">
                    <div class="row mt-3">
                        <div class="col-lg-8">
                            @foreach ($carts as $cart)
                                <div class="row cart-item" data-id="{{ $cart->id }}">
                                    <div class="col">
                                        <div class="card mb-3">
                                            <div class="row g-0">
                                                <div class="col-md-4 foto-produk">
                                                    <img src="{{ asset('storage/products/' . $cart->product->image) }}"
                                                        class="img-fluid rounded-start" alt="foto-produk">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $cart->product->title }}</h5>
                                                        <div class="row mt-5">
                                                            <div class="col-lg-4">
                                                                <label for="jumlah" class="form-label">Jumlah</label>
                                                                <div class="d-flex">
                                                                    <input type="number" class="form-control me-2 weight"
                                                                        value="{{ $cart->weight }}"
                                                                        min="{{ $min }}" max="{{ $max }}"
                                                                        oninput="this.value = Math.max(this.min, Math.min(this.max, this.value));">
                                                                    <h6>Kg</h6>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label for="harga" class="form-label">Harga/kg</label>
                                                                <h5 id="item-price">{{ moneyFormat($cart->price / $cart->weight) }}</h5>
                                                            </div>

                                                            <div class="col-lg-4 text-end">
                                                                <button type="button" class="btn btn-danger delete-cart"
                                                                    data-id="{{ $cart->id }}">Hapus</button>
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

                        <div class="col-lg-4">
                            <div class="card p-3">
                                <div class="card-body">
                                    <h3>Ringkasan Belanja</h3>
                                    <h6 id="total-weight">Jumlah : {{ $carts->sum('weight') }} kg</h6>
                                    <h4 id="total-price">Total : {{ moneyFormat($carts->sum('price')) }}</h4>

                                    <button type="submit" class="btn btn-success w-100 mt-3">Lanjutkan ke Pembayaran</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </section>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // update summary berdasarkan weight yang diupdate
            function updateSummary() {
                var totalWeight = 0;
                var totalPrice = 0;

                // Looping semua item yang ada di keranjang
                $('.cart-item').each(function() {
                    var weight = parseInt($(this).find('.weight').val());
                    var price = parseFloat($(this).find('#item-price').text().replace('Rp ', '').replace('.', '').replace(',', '.'));

                    totalWeight += weight;
                    totalPrice += price * weight;
                });

                // Update summary berdasarkan total weight dan total price
                $('#total-weight').text('Jumlah : ' + totalWeight + ' kg');
                $('#total-price').text('Total : Rp ' + totalPrice.toLocaleString('id-ID'));
            }

            // panggil function updateSummary saat halaman pertama kali di load
            $('.weight').on('change', function() {
                var row = $(this).closest('.row');
                var cartId = row.find('.delete-cart').data('id');
                var weight = $(this).val();

                // update weight item di keranjang berdasarkan id item dan weight yang diupdate custommer
                $.ajax({
                    url: '{{ url('/carts/update') }}/' + cartId,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        weight: weight
                    },
                    // jika request berhasil, maka akan menampilkan toastr success
                    success: function(response) {
                        if (response.status === 'success') {
                            row.find('#item-price').text('Rp ' + (response.cart.price / response.cart.weight).toLocaleString('id-ID'));
                            toastr.options = {
                                "positionClass": "toast-top-center",
                                "progressBar": true,
                            };
                            toastr.success(response.message);
                            updateSummary();
                        } else {
                            // jika request gagal, maka akan menampilkan toastr error
                            toastr.options = {
                                "positionClass": "toast-top-center",
                                "progressBar": true,
                            };
                            toastr.error(response.message);
                        }
                    },
                    // jika request gagal, maka akan menampilkan toastr error
                    error: function(response) {
                        toastr.options = {
                            "positionClass": "toast-top-center",
                            "progressBar": true,
                        };
                        toastr.error(response.responseJSON.message);
                    }
                });
            });

            // Hapus item di keranjang
            $('.delete-cart').on('click', function() {
                var row = $(this).closest('.row');
                var cartId = $(this).data('id');

                // Hapus item di keranjang berdasarkan id item yang dihapus
                $.ajax({
                    url: '{{ url('/carts/delete') }}/' + cartId,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    // Jika request berhasil, maka akan menampilkan sweetalert success
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                row.remove();
                                updateSummary();
                                location.reload();
                            });
                        } else {
                            // Jika request gagal, maka akan menampilkan sweetalert error
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message,
                            });
                        }
                    },
                    // Jika request gagal, maka akan menampilkan sweetalert error
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.responseJSON.message,
                        });
                    }
                });
            });
        });
    </script>
@endpush
