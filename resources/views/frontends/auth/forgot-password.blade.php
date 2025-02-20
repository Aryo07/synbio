@extends('frontends.layouts.guest', ['title' => 'Forgot Password'])

@section('content')
    <section id="login">
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="bg-login p-4">
                <div class="row">
                    <div class="col text-center">
                        <img src="{{ asset('frontends/Assets/Logo.png') }}" alt="logo" class="img-fluid mb-3">

                        <h1>Lupa Password</h1>
                        <p>Masukkan email untuk mereset password.</p>

                        <!-- form -->
                        <form method="POST" action="{{ route('forgot-password.email') }}">
                            @csrf

                            <div class="mb-3 text-start">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control custom-width @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="cth. example@gmail.com">

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button class="btn btn-success w-100 mt-4">Kirim Link Reset Password</button>

                            <p class="mt-4">Ingat akun? <a href="{{ route('login') }}" class="text-success">Masuk</a></p>
                        </form>
                        <!-- form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
