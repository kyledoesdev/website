<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\ConnectionController;
use App\Livewire\Blog;
use App\Livewire\BlogViews;
use App\Livewire\BoardGames;
use App\Livewire\Connection;
use App\Livewire\Dashboard;
use App\Livewire\Education;
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
use App\Livewire\Printing;
use App\Livewire\Projects;
use App\Livewire\Resume;
use App\Livewire\Technologies;
use App\Livewire\WorkHistory;
use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;

Route::view('/', 'welcome')->name('welcome');

/* Career Views */
Route::get('/education', Education::class)->name('education');
Route::get('/projects', Projects::class)->name('projects');
Route::get('/technology', Technologies::class)->name('technologies');
Route::get('/work_history', WorkHistory::class)->name('work_history');

/* Hobby Views */
Route::get('/board_games', BoardGames::class)->name('board_games');
Route::get('/movies', ShowMovies::class)->name('movies');
Route::get('/music', ShowMusic::class)->name('music');
Route::get('/tv', ShowTv::class)->name('tv_shows');
Route::get('/video_games', ShowGames::class)->name('video_games');
Route::get('/gallery', Gallery::class)->name('gallery');
Route::get('/3d_printing', Printing::class)->name('3d_printing');

Route::get('/asset/{slug}', AssetController::class)->name('asset');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/connect/{type}', [ConnectionController::class, 'connect'])->name('connect');
    Route::get('/connection/callback', [ConnectionController::class, 'processConnection'])->name('process_connection');
    Route::get('/connections/edit', Connection::class)->name('connections.edit');

    Route::get('/blog/edit', Blog::class)->name('blog.edit');
    Route::get('/blog/{post}/views', BlogViews::class)->name('blog.post_views');

    Route::get('/panels', Panels::class)->name('panels');

    Route::get('/movies/edit', EditMovies::class)->name('movies.edit');
    Route::get('/tv/edit', EditTv::class)->name('tv.edit');

    Route::get('/music/edit', EditMusic::class)->name('music.edit');
    Route::get('/video_games/edit', EditGames::class)->name('video_games.edit');

    Route::get('/gallery/edit', Uploader::class)->name('gallery.edit');
    Route::get('/resumes/edit', Resume::class)->name('resume.edit');

    Route::get('/health', HealthCheckResultsController::class)->name('health.index');
});

require __DIR__.'/auth.php';
require __DIR__.'/prezet.php';
