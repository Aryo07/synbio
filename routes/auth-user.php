<?php

use App\Http\Controllers\Frontends\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');
    Route::post('/login', [AuthController::class, 'login_post']);

    Route::get('/register', [AuthController::class, 'register'])
        ->name('register');
    Route::post('/register', [AuthController::class, 'register_post']);

    Route::get('/forgot-password', [AuthController::class, 'forgot_password'])
        ->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgot_password_post'])
    ->name('forgot-password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'reset_password'])
        ->name('reset-password');

    Route::post('/reset-password', [AuthController::class, 'reset_password_post'])
        ->name('reset-password.update');
});

Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])
    ->name('logout');
});
