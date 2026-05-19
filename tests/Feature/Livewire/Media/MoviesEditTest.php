<?php

use App\Enums\Media\MovieState;
use App\Livewire\Media\Movies\Edit;
use App\Models\Media;
use Livewire\Livewire;

it('toggles each allowed state on and back off', function (MovieState $state) {
    $movie = Media::factory()->movie()->create();

    Livewire::test(Edit::class)
        ->call('toggleState', $movie->getKey(), $state->value)
        ->assertOk();

    expect($state->getValue($movie->fresh()))->toBeTrue();

    Livewire::test(Edit::class)
        ->call('toggleState', $movie->getKey(), $state->value)
        ->assertOk();

    expect($state->getValue($movie->fresh()))->toBeFalse();
})->with([
    MovieState::Favorite,
    MovieState::Backlog,
    MovieState::Completed,
]);

it('rejects states that are not toggleable for movies', function (string $value) {
    $movie = Media::factory()->movie()->create();

    Livewire::test(Edit::class)
        ->call('toggleState', $movie->getKey(), $value)
        ->assertStatus(422);
})->with(['is_active', 'total_completion', 'type_id']);

it('destroys a movie', function () {
    $movie = Media::factory()->movie()->create();

    Livewire::test(Edit::class)
        ->call('destroy', $movie->getKey())
        ->assertOk();

    expect(Media::find($movie->getKey()))->toBeNull();
});
