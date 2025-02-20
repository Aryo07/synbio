@extends('frontends.layouts.guest', ['title' => 'Reset Password'])

@section('content')
    <section id="login">
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="bg-login p-4">
                <div class="row">
                    <div class="col text-center">
                        <img src="{{ asset('frontends/Assets/Logo.png') }}" alt="logo" class="img-fluid mb-3">
                        <h1>Reset Password</h1>
                        <p>Masukkan email dan password baru.</p>

                        <!-- form -->
                        <form method="POST" action="{{ route('reset-password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <div class="mb-3 text-start">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control custom-width @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $request->email) }}" placeholder="cth. example@gmail.com">

                                @error('email')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3 text-start">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control custom-width @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password">

                                @error('password')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3 text-start">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control custom-width @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi password">

                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <button class="btn btn-success w-100 mt-4">Reset Password</button>

                            <p class="mt-4">Ingat akun? <a href="{{ route('login') }}" class="text-success">Masuk</a></p>
                        </form>
                        <!-- form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
