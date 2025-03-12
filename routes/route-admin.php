<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backends\BankController;
use App\Http\Controllers\Backends\UserController;
use App\Http\Controllers\Backends\CourierController;
use App\Http\Controllers\Backends\DashboardController;
use App\Http\Controllers\Backends\BannerController;
use App\Http\Controllers\Backends\ProductController;

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

    // Bank Route
    // Route::resource('banks', BankController::class);
    // Route::resource('banks', BankController::class)->except(['show']);
    Route::get('/banks', action: [BankController::class, 'index'])
        ->name('admin.banks.index');
    Route::get('/banks/create', action: [BankController::class, 'create'])
        ->name('admin.banks.create');
    Route::post('/banks', action: [BankController::class, 'store'])
        ->name('admin.banks.store');
    Route::get('/banks/{bank}/edit', action: [BankController::class, 'edit'])
        ->name('admin.banks.edit');
    Route::put('/banks/{bank}', action: [BankController::class, 'update'])
        ->name('admin.banks.update');
    Route::delete('/banks/{bank}', action: [BankController::class, 'destroy'])
        ->name('admin.banks.destroy');

    // Courier Route
    // Route::resource('couriers', CourierController::class);
    // Route::resource('couriers', CourierController::class)->except(['show']);
    Route::get('/couriers', action: [CourierController::class, 'index'])
        ->name('admin.couriers.index');
    Route::get('/couriers/create', action: [CourierController::class, 'create'])
        ->name('admin.couriers.create');
    Route::post('/couriers', action: [CourierController::class, 'store'])
        ->name('admin.couriers.store');
    Route::get('/couriers/{courier}/edit', action: [CourierController::class, 'edit'])
        ->name('admin.couriers.edit');
    Route::put('/couriers/{courier}', action: [CourierController::class, 'update'])
        ->name('admin.couriers.update');
    Route::delete('/couriers/{courier}', action: [CourierController::class, 'destroy'])
        ->name('admin.couriers.destroy');

    // User Route
    // Route::resource('users', UserController::class);
    // Route::resource('users', UserController::class)->except(['show']);
    Route::get('/users', action: [UserController::class, 'index'])
        ->name('admin.users.index');
    Route::get('/users/create', action: [UserController::class, 'create'])
        ->name('admin.users.create');
    Route::post('/users', action: [UserController::class, 'store'])
        ->name('admin.users.store');
    Route::get('/users/{user}/edit', action: [UserController::class, 'edit'])
        ->name('admin.users.edit');
    Route::put('/users/{user}', action: [UserController::class, 'update'])
        ->name('admin.users.update');
    Route::delete('/users/{user}', action: [UserController::class, 'destroy'])
        ->name('admin.users.destroy');
});