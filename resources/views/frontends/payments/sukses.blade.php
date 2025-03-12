@extends('frontends.layouts.app', ['title' => 'Sukses'])

@section('content')
    <section id="success">
        <div class="container">
            <div class="row text-center">
                <div class="col">
                    <h3 class="text-success">Selamat! Pesanan Anda berhasil diproses!</h3>
                    <img src="{{ asset('frontends/assets/img-success.png') }}" alt="success">
                </div>
                <a class="text-success" href="{{ route('home') }}">Kembali ke Beranda</a>
            </div>
            
        </div>
    </section>
@endsection