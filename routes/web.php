<?php

use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\WelcomeController;
use App\Livewire\Blog;
use App\Livewire\Connection;
use App\Livewire\Dashboard;
use App\Livewire\Media\Games\Edit as EditGames;
use App\Livewire\Media\Games\Show as ShowGames;
use App\Livewire\Media\Movies\Edit as EditMovies;
use App\Livewire\Media\Movies\Show as ShowMovies;
use App\Livewire\Media\Music\Edit as EditMusic;
use App\Livewire\Media\Music\Show as ShowMusic;
use App\Livewire\Media\Tv\Edit as EditTv;
use App\Livewire\Media\Tv\Show as ShowTv;
use App\Livewire\Panels;
use App\Livewire\Photos\Gallery;
use App\Livewire\Photos\Uploader;
use App\Livewire\Resume;
use App\Livewire\Technologies;
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
Route::get('/movies', ShowMovies::class)->name('movies');
Route::get('/music', ShowMusic::class)->name('music');
Route::get('/tv', ShowTv::class)->name('tv_shows');
Route::get('/video_games', ShowGames::class)->name('video_games');
Route::get('/gallery', Gallery::class)->name('gallery');

Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/connections/edit', Connection::class)->name('connections.edit');
    Route::get('/blog/edit', Blog::class)->name('blog.edit');

    Route::get('/board_games/edit', Panels::class)->name('board_games.edit');
    Route::get('/education/edit', Panels::class)->name('education.edit');
    Route::get('/panels', Panels::class)->name('panels');
    Route::get('/projects/edit', Panels::class)->name('projects.edit');
    Route::get('/work_history/edit', Panels::class)->name('work_history.edit');
    
    Route::get('/movies/edit', EditMovies::class)->name('movies.edit');
    Route::get('/tv/edit', EditTv::class)->name('tv.edit');
    
    Route::get('/music/edit', EditMusic::class)->name('music.edit');
    Route::get('/technology/edit', Technologies::class)->name('technology.edit');
    Route::get('/video_games/edit', EditGames::class)->name('video_games.edit');

    Route::get('/gallery/edit', Uploader::class)->name('gallery.edit');
    Route::get('/resumes/edit', Resume::class)->name('resume.edit');    
});
    
require __DIR__.'/auth.php';
require __DIR__.'/prezet.php';