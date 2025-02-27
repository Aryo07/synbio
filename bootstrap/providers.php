<?php

use Illuminate\Pagination\Paginator;

return [
    App\Providers\AppServiceProvider::class,

    // Pagination
    Paginator::useBootstrap(),

    Barryvdh\Debugbar\ServiceProvider::class,
];
