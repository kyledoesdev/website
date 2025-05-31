<?php

use App\Models\Asset;

it('can load public pages', function () {
    Asset::factory()->resume()->create();

    $this->get(route('welcome'))->assertOk();
    $this->get(route('education'))->assertOk();
    $this->get(route('projects'))->assertOk();
    $this->get(route('technologies'))->assertOk();
    $this->get(route('work_history'))->assertOk();
    $this->get(route('board_games'))->assertOk();
    $this->get(route('movies'))->assertOk();
    $this->get(route('music'))->assertOk();
    $this->get(route('video_games'))->assertOk();
    $this->get(route('gallery'))->assertOk();
});
