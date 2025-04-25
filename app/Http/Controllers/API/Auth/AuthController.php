<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi request menggunakan $validator
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|min:8',
            ],
            [
                'email' => 'Email tidak boleh kosong!',
                'password.required' => 'Password tidak boleh kosong!',
                'password.min' => 'Password minimal 8 karakter!',
            ]
        );

        // Cek validasi jika tidak sesuai maka akan mengembalikan response error berupa pesan error yang dihasilkan oleh $validator
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], 422);
        }

        // Cek user berdasarkan email yang dimasukkan oleh user sesuai dengan email yang ada di database atau tidak
        $user = User::where('email', $request->email)->first();

        // Cek email dan password sesuai atau tidak
        if ($user && Hash::check($request->password, $user->password)) {
            // Jika berhasil login maka akan dibuatkan token untuk user tersebut
            $token = $user->createToken('authToken')->plainTextToken;
            // Mengembalikan response berupa data user dan token yang dihasilkan
            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil!',
                'data' => [
                    'user' => $user,
                    'token_type' => 'Bearer',
                    'token' => $token,
                ],
            ], 200);
        } else {
            // Cek email jika tidak ditemukan di database maka akan mengembalikan response error
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email tidak terdaftar!',
                ], 404);
            } else {
                // Cek password jika tidak sesuai dengan password yang ada di database maka akan mengembalikan response error
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password salah!',
                ], 401);
            }
        }
    }

    public function getUser()
    {
        // Mengembalikan response berupa data user yang sedang login
        return response()->json([
            'status' => 'success',
            'message' => 'Data user berhasil diambil!',
            'data' => Auth::user(),
        ], 200);
    }

    public function logout()
    {
        // Proses logout user dengan menghapus token yang dimiliki oleh user
        $user = User::where('id', Auth::id())->first();
        $user->tokens()->delete();

        // Mengembalikan response berhasil logout
        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil'
        ], 200);
    }
}
