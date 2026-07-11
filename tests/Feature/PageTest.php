<?php

use App\Models\Asset;
use App\Models\User;

it('can load public pages', function () {
    Asset::factory()->resume()->create();

    $this->get(route('welcome'))->assertOk();
    $this->get(route('education'))->assertOk();
    $this->get(route('projects'))->assertOk();
    $this->get(route('technologies'))->assertOk();
    $this->get(route('work_history'))->assertOk();
    $this->get(route('board_games'))->assertOk();
    $this->get(route('3d_printing'))->assertOk();
    $this->get(route('movies'))->assertOk();
    $this->get(route('music'))->assertOk();
    $this->get(route('video_games'))->assertOk();
    $this->get(route('gallery'))->assertOk();
});

it('shows the guest view on pure-panel pages even when logged in', function (string $route) {
    Asset::factory()->resume()->create();

    $this->actingAs(User::factory()->create());

    $this->get(route($route))
        ->assertOk()
        ->assertDontSee('wire:model="content', escape: false);
})->with([
    'education',
    'projects',
    'work_history',
    'board_games',
    '3d_printing',
]);

it('gates the 3d printing edit page behind auth', function () {
    Asset::factory()->resume()->create();

    $this->get(route('3d_printing.edit'))->assertRedirect(route('login'));

    $this->actingAs(User::factory()->create())
        ->get(route('3d_printing.edit'))
        ->assertOk();
});
