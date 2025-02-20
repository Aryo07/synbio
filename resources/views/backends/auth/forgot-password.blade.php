@extends('backends.layouts.guest', ['title' => 'Forgot Password'])

@section('content')
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <div class="auth-logo">
                <a href="{{ route('admin.forgot-password.email') }}"><img src="{{ asset('backends/assets/compiled/svg/logo.svg') }}" alt="Logo"></a>
            </div>
            <h1 class="auth-title">Lupa Password?</h1>
            <p class="auth-subtitle mb-5">Masukkan email Anda dan kami akan mengirimkan tautan reset kata sandi.</p>

            <form method="POST" action="{{ route('admin.forgot-password.email') }}">
                @csrf

                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="email" class="form-control form-control-xl @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Kirim Link Reset Password</button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p class='text-gray-600'>Ingat akun Anda? <a href="{{ route('admin.login') }}" class="font-bold">Masuk</a>.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">

        </div>
    </div>
@endsection
