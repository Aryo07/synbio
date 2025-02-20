@extends('frontends.layouts.guest', ['title' => 'Register'])

@section('content')
<section id="register">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-register p-4">
            <div class="row">
                <div class="col text-center">
                    <img src="{{ asset('frontends/Assets/Logo.png') }}" alt="logo">
                    <h1>Daftar Akun</h1>
                    <p>Buat Akun untuk berbelanja.</p>

                    <!-- form -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row text-start mb-3">
                            <div class="col-lg-6">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="cth. Ahmad Fulan">

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="cth. 628xxxxxxx">

                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row text-start mb-3">
                            <div class="col">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="cth. example@gmail.com">

                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row text-start mb-3">
                            <div class="col-lg-6">
                                <label for="password" class="form-label">Buat Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password">

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi password">

                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <input type="submit" class="btn btn-success w-100 mt-5" value="Buat Akun">

                        <p class="mt-5">Sudah punya akun? <a href="{{ route('login') }}" class="text-success">Login Akun</a></p>
                    </form>
                    <!-- form -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
