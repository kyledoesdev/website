<?php

it('can load welcome page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('can load work history page', function () {
    $response = $this->get(route('work_history'));

    $response->assertStatus(200);
});

it('can load education page', function () {
    $response = $this->get(route('education'));

    $response->assertStatus(200);
});

it('can load projects page', function () {
    $response = $this->get(route('projects'));

    $response->assertStatus(200);
});

it('can load technology page', function () {
    $response = $this->get(route('technologies'));

    $response->assertStatus(200);
});

it('can load gallery', function () {
    $response = $this->get(route('gallery'));

    $response->assertStatus(200);
});
