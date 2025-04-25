@extends('frontends.layouts.app', ['title' => 'Home'])

@section('content')
<!-- hero -->
@foreach ($banners as $banner)
    @if ($banner->position == 1)
        <section id="hero" style="background-image: url('{{ asset('storage/banners/' . $banner->image) }}');">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="konten-hero">
                            <h1>{{ $banner->title }} <span class="text-success">{{ $banner->subtitle }}</span></h1>
                            <p class="pt-3 pb-3">{!! $banner->description !!}</p>
                            <a class="btn btn-outline-success" href="{{ route('products.page') }}">Mulai Belanja</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endforeach
<!-- hero -->

<!-- produk -->
<section id="produk">
    <div class="container">
        <!-- Produk Terbaik -->
        {{-- @if ($productsOrders->count() > 0) --}}
        @if ($productsOrders->isNotEmpty())
            <div class="row">
                <div class="col-lg-6">
                    <h4>Produk Terbaik</h4>
                </div>
                <div class="col-lg-6">
                    <a class="more" href="{{ route('products.page') }}">Lihat Semua Produk <i class="fa-solid fa-arrow-right ps-2"></i></a>
                </div>
            </div>

            <div class="row mt-3">
                @foreach ($productsOrders as $product)
                    <div class="col-lg-3">
                        <a class="card card-produk" href="{{ route('products.detail', $product->slug) }}">
                            <div class="foto-produk border p-5">
                                @if($product->image && file_exists(public_path('storage/products/' . $product->image)))
                                <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->title }}" class="card-img-top">
                                @else
                                <img src="https://dummyimage.com/1440x600/942594/ffffff.png&text=Product+Tidak+Ada" alt="{{ $product->title }}" class="card-img-top">
                                @endif
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-tittle">{{ $product->title }}</h5>
                                <p class="card-text">{{ moneyFormat($product->price) }}/kg</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Produk Lainnya -->
        <div class="row mt-5">
            <div class="col-lg-6">
                <h4>Produk Lainnya</h4>
            </div>
            <div class="col-lg-6">
                <a class="more" href="{{ route('products.page') }}">Lihat Semua Produk <i class="fa-solid fa-arrow-right ps-2"></i></a>
            </div>
        </div>

        <div class="row mt-3">
            @foreach ($products as $product)
            <div class="col-lg-3">
                <a class="card card-produk" href="{{ route('products.detail', $product->slug) }}">
                    <div class="foto-produk border p-5">
                        @if($product->image && file_exists(public_path('storage/products/' . $product->image)))
                        <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->title }}" class="card-img-top">
                        @else
                        <img src="https://dummyimage.com/1440x600/942594/ffffff.png&text=Product+Tidak+Ada" alt="{{ $product->title }}" class="card-img-top">
                        @endif
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-tittle">{{ $product->title }}</h5>
                        <p class="card-text">{{ moneyFormat($product->price) }}/kg</p>
                    </div>
                </a>
            </div>

            @endforeach
        </div>
    </div>
</section>
<!-- produk -->

<!-- cta -->
@foreach ($banners as $banner)
    @if ($banner->position == 2)
        <section id="cta">
            <div class="container bg-cta" style="background-image: url('{{ asset('storage/banners/' . $banner->image) }}');">
                <div class="row text-center">
                    <div class="col">
                        <h6>{{ $banner->subtitle }}</h6>
                        <h1>{!! $banner->title !!}</h1>
                        <p>{!! $banner->description !!}</p>
                        <a class="btn btn-success" href="{{ route('products.page') }}">Mulai Belanja</a>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endforeach
<!-- cta -->
@endsection
