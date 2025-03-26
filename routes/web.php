<?php

use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\WelcomeController;
use App\Livewire\Photos\Gallery;
use Illuminate\Support\Facades\Route;

Route::get('/connect/{type}', [ConnectionController::class, 'connect'])->name('connect');
Route::get('/connection/callback', [ConnectionController::class, 'processConnection'])->name('process_connection');

/* Career Views */
Route::view('/', 'welcome')->name('welcome');
Route::view('/education', 'pages.education')->name('education');
Route::view('/projects', 'pages.projects')->name('projects');
Route::view('/technology', 'pages.technologies')->name('technologies');
Route::view('/work_history', 'pages.work_history')->name('work_history');

/* Hobby Views */
Route::view('/board_games', 'pages.board_games')->name('board_games');
Route::view('/movies', 'pages.movies')->name('movies');
Route::view('/music', 'pages.music')->name('music');
Route::view('/tv', 'pages.tv_shows')->name('tv_shows');
Route::view('/video_games', 'pages.video_games')->name('video_games');
Route::get('/gallery', Gallery::class)->name('gallery');

Route::middleware(['auth'])->group(function() {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
});
    
require __DIR__.'/auth.php';
require __DIR__.'/prezet.php';