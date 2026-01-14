<?php

use App\Livewire\Auth\ConfirmPassword;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\ResetPassword;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::livewire('admin', Login::class)
        ->name('login');

    Route::livewire('forgot-password', ForgotPassword::class)
        ->name('password.request');

    Route::livewire('reset-password/{token}', ResetPassword::class)
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::livewire('confirm-password', ConfirmPassword::class)
        ->name('password.confirm');
});
