<?php

use App\Enums\Media\TvState;
use App\Livewire\Media\Tv\Edit;
use App\Models\Media;
use Livewire\Livewire;

it('toggles each allowed state on and back off', function (TvState $state) {
    $show = Media::factory()->tv()->create();

    Livewire::test(Edit::class)
        ->call('toggleState', $show->getKey(), $state->value)
        ->assertOk();

    expect($state->getValue($show->fresh()))->toBeTrue();

    Livewire::test(Edit::class)
        ->call('toggleState', $show->getKey(), $state->value)
        ->assertOk();

    expect($state->getValue($show->fresh()))->toBeFalse();
})->with([
    TvState::Favorite,
    TvState::Active,
    TvState::Backlog,
    TvState::Completed,
]);

it('rejects states that are not toggleable for tv shows', function (string $value) {
    $show = Media::factory()->tv()->create();

    Livewire::test(Edit::class)
        ->call('toggleState', $show->getKey(), $value)
        ->assertStatus(422);
})->with(['total_completion', 'type_id']);

it('destroys a tv show', function () {
    $show = Media::factory()->tv()->create();

    Livewire::test(Edit::class)
        ->call('destroy', $show->getKey())
        ->assertOk();

    expect(Media::find($show->getKey()))->toBeNull();
});
