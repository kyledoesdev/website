<?php

use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\WelcomeController;
use App\Livewire\BoardGame;
use App\Livewire\Dashboard;
use App\Livewire\Media;
use App\Livewire\Panels;
use App\Livewire\Photos\Gallery;
use App\Livewire\Resume;
use App\Livewire\Technologies;
use App\Livewire\VideoGames;
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
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/board_games/edit', Panels::class)->name('board_games.edit');
    Route::get('/education/edit', Panels::class)->name('education.edit');
    Route::get('/movies/edit', Media::class)->name('movies.edit');
    Route::get('/music/edit', Panels::class)->name('music.edit');
    Route::get('/panels', Panels::class)->name('panels');
    Route::get('/projects/edit', Panels::class)->name('projects.edit');
    Route::get('/resumes/edit', Resume::class)->name('resume.edit');
    Route::get('/technology/edit', Technologies::class)->name('technology.edit');
    Route::get('/tv/edit', Media::class)->name('tv.edit');
    Route::get('/work_history/edit', Panels::class)->name('work_history.edit');
    Route::get('/video_games/edit', VideoGames::class)->name('video_games.edit');
});
    
require __DIR__.'/auth.php';
require __DIR__.'/prezet.php';