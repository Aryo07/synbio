<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontends\HomeController;
use App\Http\Controllers\Backends\BannerController;
use App\Http\Controllers\Backends\DashboardController;
use App\Http\Controllers\Backends\ProductController;

Route::get('/', function () {
    return view('welcome');
});

// User Route
Route::middleware('auth')->group(function(){
    Route::get('/home', action: [HomeController::class, 'home'])
    ->name('home');
});

// Admin Route
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/dashboard', action: [DashboardController::class, 'dashboard'])
        ->name('admin.dashboard');

    // Banner Route
    // Route::resource('banners', BannerController::class);
    // Route::resource('banners', BannerController::class)->except(['show']);
    Route::get('/banners', action: [BannerController::class, 'index'])
        ->name('admin.banners.index');
    Route::get('/banners/create', action: [BannerController::class, 'create'])
        ->name('admin.banners.create');
    Route::post('/banners', action: [BannerController::class, 'store'])
        ->name('admin.banners.store');
    Route::get('/banners/{banner}', action: [BannerController::class, 'show'])
        ->name('admin.banners.show');
    Route::get('/banners/{banner}/edit', action: [BannerController::class, 'edit'])
        ->name('admin.banners.edit');
    Route::put('/banners/{banner}', action: [BannerController::class, 'update'])
        ->name('admin.banners.update');
    Route::delete('/banners/{banner}', action: [BannerController::class, 'destroy'])
        ->name('admin.banners.destroy');

    // Product Route
    // Route::resource('products', ProductController::class);
    // Route::resource('products', ProductController::class)->except(['show']);
    Route::get('/products', action: [ProductController::class, 'index'])
        ->name('admin.products.index');
    Route::get('/products/create', action: [ProductController::class, 'create'])
        ->name('admin.products.create');
    Route::post('/products', action: [ProductController::class, 'store'])
        ->name('admin.products.store');
    Route::get('/products/{product}/edit', action: [ProductController::class, 'edit'])
        ->name('admin.products.edit');
    Route::put('/products/{product}', action: [ProductController::class, 'update'])
        ->name('admin.products.update');
    Route::delete('/products/{product}', action: [ProductController::class, 'destroy'])
        ->name('admin.products.destroy');
});

require __DIR__ . '/auth-admin.php';
require __DIR__ . '/auth-user.php';
