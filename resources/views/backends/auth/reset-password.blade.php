@extends('backends.layouts.guest', ['title' => 'Reset Password'])

@section('content')
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <div class="auth-logo">
                <a href="{{ route('admin.reset-password.update') }}"><img src="{{ asset('backends/assets/compiled/svg/logo.svg') }}" alt="Logo"></a>
            </div>
            <h1 class="auth-title">Reset Password.</h1>
            <p class="auth-subtitle mb-5">Silahkan masukan kata sandi baru Anda.</p>

            <form method="POST" action="{{ route('admin.reset-password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="email" class="form-control form-control-xl @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $request->email) }}" placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>

                    @error('email')
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" class="form-control form-control-xl @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password Baru">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>

                    @error('password')
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" class="form-control form-control-xl @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password Baru">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>

                    @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Konfirmasi Password</button>
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
