<?php

namespace App\Http\Controllers\Backends\Auth;

use App\Models\Admin;
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
        return view('backends.auth.login');
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

        // contoh $admin disebut variabel
        $admin = Admin::where('email', operator: $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            $remember = $request->has('remember');
            Auth::guard('admin')->login($admin, $remember);

            if ($remember) {
                $admin->forceFill([
                    'remember_token' => Str::random(60),
                ])->save();
            }

            toastr()
                ->positionClass('toast-top-center')
                ->success('Login berhasil!');

            return redirect()->route('admin.dashboard');
        } else {
            if (!$admin) {
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

    public function forgot_password()
    {
        return view('backends.auth.forgot-password');
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

        $admin = Admin::where('email', $request->email)->first();

        if ($admin) {
            $token = Password::getRepository()->create($admin);
            $email = $request->only('email')['email'];
            $url = URL::to('/admin/reset-password/' . $token . '?email=' . urlencode($email));
            $expiresAt = config('auth.passwords.admins.expire');

            // kirim email dengan URL yang disesuaikan
            Mail::send('emails.email', ['url' => $url, 'expiresAt' => $expiresAt], function ($message) use ($email) {
                $message->to($email);
                $message->subject('Atur Ulang Password Akun');
            });

            toastr()
                ->positionClass('toast-top-center')
                ->success('Email reset password berhasil dikirim! Silahkan cek email Anda.');
            return redirect()->route('admin.login');
        }

        toastr()
            ->positionClass('toast-top-center')
            ->error('Email tidak terdaftar!');
        return redirect()->back();
    }

    public function reset_password(Request $request)
    {
        return view('backends.auth.reset-password', [
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

        $status = Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Admin $admin) use ($request) {
                $admin->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(PasswordReset::class, $admin);
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            toastr()
                ->positionClass('toast-top-center')
                ->success('Password berhasil diatur ulang! Silahkan login.');
            return redirect()->route('admin.login');
        } else {
            toastr()
                ->positionClass('toast-top-center')
                ->error('Token tidak valid atau sudah expired!');
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toastr()
            ->positionClass('toast-top-center')
            ->success('Logout berhasil!');

        return redirect()->route('admin.login');
    }
}
