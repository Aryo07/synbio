@extends('frontends.layouts.guest', ['title' => 'Login'])

@section('content')
    <section id="login">
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="bg-login p-4">
                <div class="row">
                    <div class="col text-center">
                        <img src="{{ asset('frontends/Assets/Logo.png') }}" alt="logo" class="img-fluid mb-3">
                        <h1>Masuk</h1>
                        <p>Masuk untuk mulai berbelanja.</p>

                        <!-- form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3 text-start">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control custom-width @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('login') }}" placeholder="cth. example@gmail.com">

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3 text-start">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control custom-width @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password">

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                                <a href="{{ route('forgot-password') }}" class="text-success">Lupa password</a>
                            </div>

                            <input type="submit" class="btn btn-success w-100 mt-4" value="Masuk">

                            <p class="mt-4">Belum punya akun? <a href="{{ route('register') }}" class="text-success">Daftar Akun</a></p>
                        </form>
                        <!-- form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
