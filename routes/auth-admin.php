<?php

use App\Http\Controllers\Backends\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])
        ->name('admin.login');
    Route::post('/login', [AuthController::class, 'login_post']);

    Route::get('/forgot-password', [AuthController::class, 'forgot_password'])
        ->name('admin.forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgot_password_post'])
    ->name('admin.forgot-password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'reset_password'])
        ->name('admin.reset-password');
    Route::post('/reset-password', [AuthController::class, 'reset_password_post'])
        ->name('admin.reset-password.update');
});

Route::prefix('admin')->middleware('admin')->group(callback: function () {
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])
    ->name('admin.logout');
});
