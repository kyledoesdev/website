<?php

it('can load blog index', function () {
    $response = $this->get(route('prezet.index'));

    $response->assertStatus(200);
});