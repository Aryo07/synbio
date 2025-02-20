<?php

namespace App\Http\Controllers\Frontends\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    public function login()
    {
        return view('frontends.auth.login');
    }

    public function login_post(Request $request)
    {
        // dd($request->all()); // fungsi dd() untuk menampilkan data request
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:8'
            ],
            [
                'email.required' => 'Email tidak boleh kosong!',
                'email.email' => 'Email tidak valid!',
                'password.required' => 'Password tidak boleh kosong!',
                'password.min' => 'Password minimal 8 karakter!'
            ]
        );

        // contoh $user disebut variabel
        $user = User::where('email', operator: $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $remember = $request->has('remember');
            Auth::guard('web')->login($user, $remember);

            if ($remember) {
                $user->forceFill([
                    'remember_token' => Str::random(60),
                ])->save();
            }

            toastr()
                ->positionClass('toast-top-center')
                ->success('Login berhasil!');

            return redirect()->route('home');
        } else {
            if (!$user) {
                toastr()
                    ->positionClass('toast-top-center')
                    ->error('Email tidak terdaftar!');
                return redirect()->back();
            } else {
                toastr()
                    ->positionClass('toast-top-center')
                    ->error('Password tidak valid!');
                return redirect()->back();
            }
        }
    }

    public function register()
    {
        return view('frontends.auth.register');
    }

    public function register_post(Request $request)
    {
        // dd($request->all()); // fungsi dd() untuk menampilkan data request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone',
            'password' => 'required|min:8|confirmed'
        ], [
            'name.required' => 'Nama tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Email tidak valid!',
            'email.unique' => 'Email sudah terdaftar!',
            'phone.required' => 'Nomor telepon tidak boleh kosong!',
            'phone.numeric' => 'Nomor telepon harus berupa angka!',
            'phone.unique' => 'Nomor telepon sudah terdaftar!',
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal 8 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak sama!'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        if ($user) {
            Auth::guard('web')->login($user);
            toastr()
                ->positionClass('toast-top-center')
                ->success('Registrasi berhasil! Silahkan login.');
            return redirect()->route('login');
        } else {
            toastr()
                ->positionClass('toast-top-center')
                ->error('Registrasi gagal! Silahkan coba lagi.');
            return redirect()->back();
        }
    }

    public function forgot_password()
    {
        return view('frontends.auth.forgot-password');
    }

    public function forgot_password_post(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'email' => 'required|email'
            ],
            [
                'email.required' => 'Email tidak boleh kosong!',
                'email.email' => 'Email tidak valid!'
            ]
        );

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token = Password::getRepository()->create($user);
            $email = $request->only('email')['email'];
            $url = URL::to('/reset-password/' . $token . '?email=' . urlencode($email));
            $expiresAt = config('auth.passwords.users.expire');

            // kirim email dengan URL yang disesuaikan
            Mail::send('emails.email', ['url' => $url, 'expiresAt' => $expiresAt], function ($message) use ($email) {
                $message->to($email);
                $message->subject('Atur Ulang Password Akun');
            });

            toastr()
                ->positionClass('toast-top-center')
                ->success('Email reset password berhasil dikirim! Silahkan cek email Anda.');
            return redirect()->route('login');
        }

        toastr()
            ->positionClass('toast-top-center')
            ->error('Email tidak terdaftar!');
        return redirect()->back();
    }

    public function reset_password(Request $request)
    {
        return view('frontends.auth.reset-password', [
            'request' => $request
        ]);
    }

    public function reset_password_post(Request $request)
    {
        $request->validate(
            [
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8|confirmed',
            ],
            [
                'token.required' => 'Token tidak boleh kosong!',
                'email.required' => 'Email tidak boleh kosong!',
                'email.email' => 'Email tidak valid!',
                'password.required' => 'Password tidak boleh kosong!',
                'password.min' => 'Password minimal 8 karakter!',
                'password.confirmed' => 'Konfirmasi password tidak sama!',
            ]
        );

        $status = Password::broker('users')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event( PasswordReset::class, $user);
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            toastr()
                ->positionClass('toast-top-center')
                ->success('Password berhasil diatur ulang! Silahkan login.');
            return redirect()->route('login');
        } else {
            toastr()
                ->positionClass('toast-top-center')
                ->error('Token tidak valid atau sudah expired!');
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toastr()
            ->positionClass('toast-top-center')
            ->success('Logout berhasil!');

        return redirect('/');
    }
}
