<?php

use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomeController::class)->name('welcome');
Route::view('/education', 'education')->name('education');
Route::view('/projects', 'projects')->name('projects');
Route::view('/technology', 'technologies')->name('technologies');
Route::view('/work_history', 'work_history')->name('work_history');
Route::view('/gallery', 'gallery')->name('gallery');

Route::middleware(['auth'])->group(function() {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/profile', 'profile')->name('profile');

});
    
require __DIR__.'/auth.php';
require __DIR__.'/prezet.php';