@extends('frontends.layouts.app', ['title' => 'Product Detail'])

@section('content')
    <!-- detail produk -->
    <section id="detail">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3>Detail Produk</h3>
                </div>
            </div>

            <div class="row mt-3 d-flex align-items-center">
                <div class="col-lg-4">
                    <div class="foto-produk border">
                        @if($product->image && file_exists(public_path('storage/products/' . $product->image)))
                            <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->title }}" class="card-img-top img-fluid">
                        @else
                            <img src="https://dummyimage.com/1440x600/942594/ffffff.png&text=Product+Tidak+Ada" alt="{{ $product->title }}" class="card-img-top img-fluid">
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <h4>{{ $product->title }}</h4>
                    <h6>Harga :</h6>
                    <h5>{{ moneyFormat($product->price)}} / kg</h5>
                    <h6>Deskripsi :</h6>
                    <p>{!! $product->description !!}</p>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>Pilih Jumlah :</h5>
                            <p class="text-secondary">*maks {{ $max }} kg</p>

                            <!-- pilih jumlah -->
                            <form action="{{ route('carts.add', $product->slug) }}" method="POST" class="d-flex">
                                @csrf
                                <input type="number" name="weight" class="form-control" value="1" min="{{ $min }}" max="{{ $max }}" oninput="this.value = Math.max(this.min, Math.min(this.max, this.value))">
                                <h6 class="ps-2">kg</h6>
                                <div class="vr ms-3 me-3"></div>
                                <button type="submit" class="btn btn-success w-100"><i class="fas fa-cart-plus me-2"></i> Keranjang</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- detail produk -->

    <!-- produk lainnya -->
    <section id="produk">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h5>Produk Lainnya</h5>
                </div>
                <div class="col-lg-6 more">
                    {{$products->links()}}
                </div>
            </div>
            <div class="row mt-3">
                @foreach($products as $product)
                                <div class="col-lg-3">
                    <a class="card card-produk" href="{{ route('products.detail', $product->slug) }}">
                        <div class="foto-produk border p-5">
                        @if($product->image && file_exists(public_path('storage/products/' . $product->image)))
                            <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->title }}" class="card-img-top img-fluid">
                        @else
                            <img src="https://dummyimage.com/1440x600/942594/ffffff.png&text=Product+Tidak+Ada" alt="{{ $product->title }}" class="card-img-top img-fluid">
                        @endif
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-tittle">{{ $product->title }}</h5>
                            <p class="card-text">{{ moneyFormat($product->price)}}/kg</p>
                        </div>
                    </a>
                </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- produk lainnya -->
@endsection