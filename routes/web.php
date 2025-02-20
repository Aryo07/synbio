<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontends\HomeController;

Route::get('/', function () {
    return view('welcome');
});

// User Route
Route::middleware('auth')->group(function(){
    Route::get('/home', action: [HomeController::class, 'home'])
    ->name('home');
});

require __DIR__ . '/auth-admin.php';
require __DIR__ . '/auth-user.php';