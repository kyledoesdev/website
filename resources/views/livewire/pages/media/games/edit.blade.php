<div>
    <x-slot name="header">Video Games</x-slot>

    <div class="space-y-4">
        <livewire:panels :type="'video_games'" :header="'Video Games'" />

        <flux:card>
            <div class="flex justify-between">
                <div class="font-semibold text-xl leading-tight mt-2">
                    <h5>Video Games</h5>
                </div>
                <div>
                    <flux:modal.trigger name="create-video_game">
                        <flux:button variant="primary" size="sm">Create</flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
        
            {{-- Table of Games --}}
            <div class="py-2">
                <div class="max-w-7xl mx-auto">
                    <div class="overflow-hidden shadow-2xs sm:rounded-lg">
                        <div class="flex justify-end items-center gap-2 w-full my-2">
                            <x-per-page-selector />
                            <flux:input
                                size="sm"
                                wire:model.live.debounce.500ms="search"
                                icon-trailing="magnifying-glass"
                                class="w-full md:w-1/4"
                            />
                        </div>

                        <flux:table :paginate="$this->games">
                            <flux:table.columns>
                                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Name</flux:table.column>
                                @foreach ($states as $state)
                                    <flux:table.column
                                        sortable
                                        :sorted="$sortBy === $state->value"
                                        :direction="$sortDirection"
                                        wire:click="sort('{{ $state->value }}')"
                                    >
                                        {{ $state->label() }}
                                    </flux:table.column>
                                @endforeach
                                <flux:table.column>Actions</flux:table.column>
                            </flux:table.columns>

                            @forelse ($this->games as $game)
                                <flux:table.row :key="$game->getKey()">
                                    <flux:table.cell>
                                        {{ $game->name }}
                                    </flux:table.cell>
                                    @foreach ($states as $state)
                                        <flux:table.cell>
                                            <flux:checkbox
                                                :checked="$state->getValue($game)"
                                                wire:click="toggleState({{ $game->getKey() }}, '{{ $state->value }}')"
                                            />
                                        </flux:table.cell>
                                    @endforeach
                                    <flux:table.cell>
                                        <flux:button
                                            variant="danger"
                                            size="sm"
                                            icon="trash"
                                            inset="top bottom"
                                            wire:click="destroy({{ $game->getKey() }})"
                                            wire:confirm="Are you sure you want to delete this game?"
                                        />
                                    </flux:table.cell>
                                </flux:table.row>
                            @empty
                                <flux:card>
                                    <div class="flex justify-center my-4">
                                        <flux:badge>No Video Games found.</flux:badge>
                                    </div>
                                </flux:card>
                            @endforelse
                        </flux:table>
                    </div>
                </div>
            </div>
        </flux:card>
    </div>

    <flux:modal name="create-video_game" class="space-y-6 md:w-1/2 md:h-full">
        @if (is_null($selectedGame))
            <div class="mb-2">
                <flux:heading size="lg">Search Twitch for a Game Category</flux:heading>
            </div>

            <flux:input.group>
                <flux:input wire:model="phrase" placeholder="Search..." required />

                <flux:button type="submit" icon="magnifying-glass" wire:click="searchCategories" />
            </flux:input.group>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($searchedGames as $key => $game)
                    <div class="flex flex-col justify-center items-center space-y-2">
                        <div>
                            <img
                                width="142" 
                                height="190"
                                class="rounded-xl"
                                src="{{ $game['cover'] }}"
                                alt="{{ $game['name'] }}"
                            />
                        </div>

                        <div>
                            <flux:button 
                                variant="ghost"
                                size="sm"
                                icon="plus"
                                wire:click="selectGame({{ $game['media_id'] }})"
                            >
                                Select Game
                            </flux:button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="space-y-5">
                <div>
                    <flux:heading size="lg">Add {{ $selectedGame['name'] }} to games list.</flux:heading>
                </div>
    
                <div>
                    <flux:checkbox.group wire:model.live="form.states">
                        @foreach ($states as $state)
                            <flux:checkbox label="{{ $state->label() }}?" value="{{ $state->value }}" />
                        @endforeach
                    </flux:checkbox.group>
                </div>

                <div>
                    <flux:button size="sm" variant="primary" icon="plus" wire:click="store">
                        Add {{ $selectedGame['name'] }}
                    </flux:button>
                </div>
            </div>
        @endif
    </flux:modal>

</div>
