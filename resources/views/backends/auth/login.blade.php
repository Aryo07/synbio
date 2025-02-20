@extends('backends.layouts.guest', ['title' => 'Login'])

@section('content')
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="{{ route('admin.login') }}"><img src="{{ asset('backends/assets/compiled/svg/logo.svg') }}" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Login.</h1>
                    <p class="auth-subtitle mb-5">Silahkan Login Untuk Memulai.</p>

                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" class="form-control form-control-xl @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-gray-600" for="remember">
                                Ingat Saya
                            </label>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Masuk</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <!-- <p class="text-gray-600">Belum punya akun? <a href="auth-register.html" class="font-bold">Daftar</a>.</p> -->
                        <p><a class="font-bold" href="{{ route('admin.forgot-password') }}">Lupa Password?</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
@endsection
