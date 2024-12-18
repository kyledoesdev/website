<?php

use BenBjurstrom\Prezet\Http\Controllers\ImageController;
use BenBjurstrom\Prezet\Http\Controllers\IndexController;
use BenBjurstrom\Prezet\Http\Controllers\OgimageController;
use BenBjurstrom\Prezet\Http\Controllers\SearchController;
use BenBjurstrom\Prezet\Http\Controllers\ShowController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;

Route::withoutMiddleware([ShareErrorsFromSession::class, VerifyCsrfToken::class])->group(function () {
    Route::get('/prezet/img/{path}', ImageController::class)
        ->name('prezet.image')
        ->where('path', '.*');

    Route::get('/prezet/ogimage/{slug}', OgimageController::class)
        ->name('prezet.ogimage')
        ->where('slug', '.*');

    Route::get('/blog', IndexController::class)
        ->name('prezet.index');

    Route::get('/blog/{slug}', ShowController::class)
        ->name('prezet.show')
        ->where('slug', '.*'); // https://laravel.com/docs/11.x/routing#parameters-encoded-forward-slashes
});