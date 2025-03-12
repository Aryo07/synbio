<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontends\CartController;
use App\Http\Controllers\Frontends\HomeController;
use App\Http\Controllers\Frontends\CheckoutController;
use App\Http\Controllers\Frontends\OrderController;
use App\Http\Controllers\Frontends\PaymentController;
use App\Http\Controllers\Frontends\SuccessController;
use App\Http\Controllers\Frontends\InvoiceController;

Route::middleware('auth')->group(function () {
    Route::get('/home', action: [HomeController::class, 'home'])
        ->name('home');

    // Cart Route
    Route::get('/carts', action: [CartController::class, 'cart'])
        ->name('carts');
    Route::post('/carts/{slug}', action: [CartController::class, 'addCart'])
        ->name('carts.add');
    Route::get('/carts/count', action: [CartController::class, 'cartCount'])
        ->name('carts.count');
    Route::post('/carts/update/{id}', action: [CartController::class, 'updateCart'])
        ->name('carts.update');
    Route::post('/carts/delete/{id}', action: [CartController::class, 'deleteCart'])
        ->name('carts.delete');

    // Checkout Route
    Route::post('/checkout', action: [CheckoutController::class, 'processCheckout'])
        ->name('checkout.process');

    // Order Route
    Route::get('/orders', action: [OrderController::class, 'index'])
        ->name('orders');
    Route::get('/orders/{orderId}/detail', action: [OrderController::class, 'show'])
        ->name('orders.detail');
    Route::put('/orders/{orderId}/update', action: [OrderController::class, 'update'])
        ->name('orders.update');

    // Payment Route
    Route::get('/payment/{paymentId}', [PaymentController::class, 'index'])
        ->name('payment.index');
    Route::get('/payment/{paymentId}/process', [PaymentController::class, 'processPayment'])
        ->name('payment.process');
    Route::post('/payment/{paymentId}/confirm', [PaymentController::class, 'confirmPayment'])
        ->name('payment.confirm');

    // success route
    Route::get('/success', [SuccessController::class, 'index'])
        ->name('payment.success')
        ->middleware('check.payment.success');

    // Invoice Route
    Route::get('/invoice/{orderId}/customer', [InvoiceController::class, 'index'])
        ->name('invoice');
});