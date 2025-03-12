<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontends\HomePageController;
use App\Http\Controllers\Frontends\ProductPageController;

Route::get('/', function () {
    return view('frontends.layouts.app');
});

// Page Route
Route::get('/', [HomePageController::class, 'index'])
    ->name('home.page');

// Product Route
Route::get('/products', [ProductPageController::class, 'index'])
    ->name('products.page');
Route::get('/products/detail/{product:slug}', [ProductPageController::class, 'show'])
    ->name('products.detail');

// Auth Route // Fungsi __DIR__ adalah fungsi bawaan PHP yang digunakan untuk mendapatkan direktori dari file yang sedang dieksekusi.
require __DIR__ . '/auth-admin.php';
require __DIR__ . '/auth-user.php';
require __DIR__ . '/route-admin.php';
require __DIR__ . '/route-user.php';

// FallBack 404 Error Route
Route::fallback(function () {
    return view('frontends.errors.404');
});