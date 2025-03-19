<?php

use App\Http\Controllers\WelcomeController;
use App\Livewire\Photos\Gallery;
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomeController::class)->name('welcome');

/* Career Views */
Route::view('/education', 'education')->name('education');
Route::view('/projects', 'projects')->name('projects');
Route::view('/technology', 'technologies')->name('technologies');
Route::view('/work_history', 'work_history')->name('work_history');

/* Hobby Views */
Route::view('/board_games', 'board_games')->name('board_games');
Route::view('/movies', 'movies')->name('movies');
Route::view('/music', 'music')->name('music');
Route::view('/tv', 'tv_shows')->name('tv_shows');
Route::view('/video_games', 'video_games')->name('video_games');
Route::get('/gallery', Gallery::class)->name('gallery');

Route::middleware(['auth'])->group(function() {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/profile', 'profile')->name('profile');
});
    
require __DIR__.'/auth.php';
require __DIR__.'/prezet.php';