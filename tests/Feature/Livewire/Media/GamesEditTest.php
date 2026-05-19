<?php

use App\Enums\Media\GameState;
use App\Enums\MediaType;
use App\Livewire\Media\Games\Edit;
use App\Models\Media;
use Livewire\Livewire;

it('toggles each column-backed state on and back off', function (GameState $state) {
    $game = Media::factory()->videoGame()->create();

    Livewire::test(Edit::class)
        ->call('toggleState', $game->getKey(), $state->value)
        ->assertOk();

    expect($state->getValue($game->fresh()))->toBeTrue();

    Livewire::test(Edit::class)
        ->call('toggleState', $game->getKey(), $state->value)
        ->assertOk();

    expect($state->getValue($game->fresh()))->toBeFalse();
})->with([
    GameState::Favorite,
    GameState::Active,
    GameState::Backlog,
    GameState::Completed,
]);

it('toggles total_completion inside the data JSON column', function () {
    $game = Media::factory()->videoGame()->create([
        'data' => ['total_completion' => false],
    ]);

    Livewire::test(Edit::class)
        ->call('toggleState', $game->getKey(), GameState::TotalCompletion->value)
        ->assertOk();

    expect($game->fresh()->data['total_completion'])->toBeTrue();

    Livewire::test(Edit::class)
        ->call('toggleState', $game->getKey(), GameState::TotalCompletion->value)
        ->assertOk();

    expect($game->fresh()->data['total_completion'])->toBeFalse();
});

it('rejects unknown state names', function () {
    $game = Media::factory()->videoGame()->create();

    Livewire::test(Edit::class)
        ->call('toggleState', $game->getKey(), 'type_id')
        ->assertStatus(422);

    expect($game->fresh()->type_id)->toBe(MediaType::VIDEO_GAME->value);
});

it('destroys a game', function () {
    $game = Media::factory()->videoGame()->create();

    Livewire::test(Edit::class)
        ->call('destroy', $game->getKey())
        ->assertOk();

    expect(Media::find($game->getKey()))->toBeNull();
});
