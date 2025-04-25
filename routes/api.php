<?php

use App\Http\Controllers\API\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('auth')->middleware('guest')->group(function () {
    // Login route
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

Route::prefix('customer')->middleware('auth:sanctum')->group(function () {
    // Get User route
    Route::get('/user', [AuthController::class, 'getUser'])->name('customer.user');
    // Logout route
    Route::get('/logout', [AuthController::class, 'logout'])->name('customer.logout');
});
