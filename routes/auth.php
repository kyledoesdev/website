<?php

use App\Livewire\Auth\ConfirmPassword;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::livewire('admin', Login::class)
        ->name('login');
});

Route::middleware('auth')->group(function () {
    Route::livewire('confirm-password', ConfirmPassword::class)
        ->name('password.confirm');
});
